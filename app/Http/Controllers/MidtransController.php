<?php

namespace App\Http\Controllers;

use App\Models\Comission;
use App\Models\DetailTransaction;
use App\Models\PaymentReseller;
use App\Models\Transaction;
use App\Models\Variations;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function callback_midtrans(Request $request){
        $http = new \GuzzleHttp\Client();
        if ($request->transaction_status == "capture" or $request->transaction_status == "settlement") {
            // get transaksi berdasarkan code inv
            $get_transaksi_reseller = PaymentReseller::where('code_invoice',$request->order_id)->first();
            if ($get_transaksi_reseller == null) {
                $get_transaksi = Transaction::where('code_inv',$request->order_id)->first();
                $TransaksiJubelio = $get_transaksi->id;
                Transaction::where('code_inv',$request->order_id)->update([
                   'status'=>"paid"
                ]);
                $order = DetailTransaction::where('transaksi_id',$get_transaksi->id)->get();
                foreach ($order as $orders) {
                    $variations = Variations::where('id',$orders['variations_id'])->first();
                    $stok = $variations->stok - $orders['qty'];
                    Variations::where('id',$variations->id)->update([
                        'stok'=>$stok
                    ]);
                }
                $jubelio = $http->post('https://api.jubelio.com/sales/orders/set-as-paid',[
                    'json'=> [
                        "ids"=> [$TransaksiJubelio]
                    ],
                    'headers' => [
                        'Authorization' => 'Bearer ' . token(),
                        'Accept'        => 'application/json',
                    ],
                ]);
                $jube = json_decode((string)$jubelio->getBody(), true);
            }else{
                PaymentReseller::where('code_invoice',$request->order_id)->update([
                    'status'=>"paid"
                 ]);
                 $transactions = Transaction::where('payment_reseller',$get_transaksi_reseller->id)->get();
                 foreach ($transactions as $transactions) {
                    Transaction::where('id',$transactions['id'])->update([
                        'status'=>'paid',
                    ]);
                    $jubelio = $http->post('https://api.jubelio.com/sales/orders/set-as-paid',[
                        'json'=> [
                            "ids"=> [$transactions['id']]
                        ],
                        'headers' => [
                            'Authorization' => 'Bearer ' . token(),
                            'Accept'        => 'application/json',
                        ],
                    ]);
                    $jube = json_decode((string)$jubelio->getBody(), true);
                    Comission::where('transaction_id',$transactions['id'])->update([
                        'status'=>'success'
                    ]);
                    $detran = DetailTransaction::where('transaction_id',$transactions['id'])->get();
                    foreach ($detran as $detrans) {
                        $variasi = Variations::where('id',$detrans['variations_id'])->first();
                        $stok_akhir = $variasi->stok - $detrans['qty'];
                        Variations::where('id',$variasi->id)->update([
                            'stok'=>$stok_akhir
                        ]);
                 }
            }

        }
    }
    else if($request->transaction_status =="pending"){
        $get_transaksi_reseller = PaymentReseller::where('code_invoice',$request->order_id)->first();
        if ($get_transaksi_reseller == null) {
            $get_transaksi = Transaction::where('code_inv',$request->order_id)->first();
            // update transaksi jadi expired
             Transaction::where('code_inv',$request->order_id)->update([
                'status'=>"pending",
                'payment_method' => $request->payment_type
            ]);
        }else{
            PaymentReseller::where('code_invoice',$request->order_id)->update([
                'status'=>'pending',
            ]);
            $transactions = Transaction::where('payment_reseller',$get_transaksi_reseller->id)->get();
                 foreach ($transactions as $transactions) {
                    Transaction::where('id',$transactions['id'])->update([
                        'status'=>'pending',
                    ]);
                }
        }

        }
    else if($request->transaction_status =="expire"){
        $get_transaksi_reseller = PaymentReseller::where('code_invoice',$request->order_id)->first();
        if ($get_transaksi_reseller == null) {
            $get_transaksi = Transaction::where('code_inv',$request->order_id)->first();
            // update transaksi jadi expired
             Transaction::where('code_inv',$request->order_id)->update([
                'status'=>"expired"
            ]);
        }else{
            PaymentReseller::where('code_invoice',$request->order_id)->update([
                'status'=>'expired'
            ]);
            $transactions = Transaction::where('payment_reseller',$get_transaksi_reseller->id)->get();
            foreach ($transactions as $transactions) {
                Transaction::where('id',$transactions['id'])->update([
                    'status'=>'expired',
                ]);
            }
        }

        }
    }
}
