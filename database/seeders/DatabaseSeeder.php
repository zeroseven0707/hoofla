<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Bank;
use App\Models\Category;
use App\Models\Comission;
use App\Models\DetailTransaction;
use App\Models\GradeReseller;
use App\Models\Logo;
use App\Models\Merk;
use App\Models\Pelanggan;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Variations;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'nabilah',
            'last_name' => 'sri',
            'email' => 'reseller@gmail.com',
            'password' => Hash::make('reseller123'), // Change 'password' to the desired password
            'no_wa' => '087765565544',
            'no_ktp' => '0998776876876',
            'foto_ktp' => 'ktp/DYt2dTfzJvKpwYc5a824oYPPeMU8eO8YrrprqjDa.jpg', // You can add a placeholder for the image path
            'province' => 'jawa barat',
            'city' => 'Tasikmalaya',
            'subdistrict' => 'Mangunreja',
            'address' => 'Perum Bumi Helang Mangkak',
            'nomor_rekening' => 6847684,
            'account_holders_name' => 'Nabilah Sri Mulyani',
            'level' => 'reseller',
            'status' => 'non active', // Change 'active' to 'non active' if needed
            'grade_id' => 1, // Change grade_id accordingly
            'bank_id' => 1, // You can add a placeholder for the bank_id
            'commission' => 11000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        User::create(
            [
                'first_name' => 'muhamad',
                'last_name' => 'sihabudin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'), // Change 'password' to the desired password
                'no_wa' => '087765565544',
                'no_ktp' => '0998776876876',
                'foto_ktp' => 'ktp/DYt2dTfzJvKpwYc5a824oYPPeMU8eO8YrrprqjDa.jpg', // You can add a placeholder for the image path
                'province' => 'jawa barat',
                'city' => 'Tasikmalaya',
                'subdistrict' => 'Mangunreja',
                'province' => 9,
                'city' => 468,
                'subdistrict' => 6482,
                'address' => 'Perum Bumi Helang Mangkak',
                'nomor_rekening' => 983984,
                'account_holders_name' => 'sihabudin',
                'level' => 'admin',
                'status' => 'active', // Change 'active' to 'non active' if needed
                'grade_id' => 1, // Change grade_id accordingly
                'bank_id' => 1, // You can add a placeholder for the bank_id
                'commission' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        GradeReseller::create([
            'name'=>'starter',
            'profit'=>5,
            'description'=>'starter'
        ]);
        GradeReseller::create(  [
            'name'=>'ultimate',
            'profit'=>7,
            'description'=>'ultimate'
        ]);
        GradeReseller::create([
            'name'=>'pro',
            'profit'=>10,
            'description'=>'pro'
        ]);
        Bank::create([
            'name'=>'BRI'
        ]);
        Merk::create([
            'code'=>'Hoofla',
            'name'=>'Hoofla'
        ]);
        $sub = [
            'Mukena',
            'Sejadah',
            'Sarung',
            'Peci',
        ];
        Category::create([
            'name'=>'Alat Sholat',
            'sub'=>$sub
        ]);
        Product::create([
            'item_group_name' => 'Raiyan Series...',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta maiores delectus quisquam dolores voluptate ut nihil! Similique repellendus assumenda aliquam consequatur ipsam porro dolorem inventore, modi velit repudiandae! Doloribus eaque ex dolorem cum quidem laudantium eveniet possimus, praesentium itaque excepturi.',
            'spesifikasi' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta maiores delectus quisquam dolores voluptate ut nihil! Similique repellendus assumenda aliquam consequatur ipsam porro dolorem inventore, modi velit repudiandae! Doloribus eaque ex dolorem cum quidem laudantium eveniet possimus, praesentium itaque excepturi.',
            'sell_this' => 1,
            'reseller_sell_price' => 18000,
            'dropshipper_sell_price' => 18000,
            'agen_sell_price' => 17000,
            'distributor_sell_price' => 16000,
            'buy_this' => 1,
            'stock_this' => 1,
            // 'buy_price' => 10000,
            'sell_price' => 20000,
            'item_category_id' => 1,
            'category_name' => 'Alat Sholat',
            'sub_category_name' => 'Mukena',
            'images' => [
                ['slug'=>'didjoiodijoid','path'=>'product/3XZ4iqrXU3dCMr0GDqz9xymCpJc0afIOIoTypCW2.jpg'],
                ['slug'=>'didjoiodijo7y','path'=>'product/CpjuYgjFt3R0MKPODMK77idzc3dG2ajxzhZ7S1fP.jpg'],
                ], // Ganti dengan nilai yang sesuai
            'brand_id' => 1, // Ganti dengan nilai yang sesuai
            'is_active' => true, // Ganti dengan nilai yang sesuai
            'recomendation' => true, // Ganti dengan nilai yang sesuai
            'package_content' => null, // Ganti dengan nilai yang sesuai
            'package_weight' => 5, // Ganti dengan nilai yang sesuai
            'package_height' => 1, // Ganti dengan nilai yang sesuai
            'package_width' => 20, // Ganti dengan nilai yang sesuai
            'package_length' => 12, // Ganti dengan nilai yang sesuai
            'brand_name' => 'samsung', // Ganti dengan nilai yang sesuai
        ]);
        $data = [
            [
                'slug' => 'jdhfiejoiedo',
                'product_id' => 1,
                'sku' => 001,
                'warna' => 'merah',
                'size' => 'm',
                'price' => 20000,
                'reseller_price' => 18000,
                'dropshipper_price' => 18000,
                'agen_price' => 17000,
                'distributor_price' => 16000,
                'stok' => 100
            ],
            [
                'slug' => 'jdhfiejoied',
                'product_id' => 1,
                'sku' => 002,
                'warna' => 'merah',
                'size' => 'l',
                'price' => 20000,
                'reseller_price' => 18000,
                'dropshipper_price' => 18000,
                'agen_price' => 17000,
                'distributor_price' => 16000,
                'stok' => 100
            ],
            [
                'slug' => 'jdhfiejoie',
                'product_id' => 1,
                'sku' => 003,
                'warna' => 'biru',
                'size' => 'm',
                'price' => 20000,
                'reseller_price' => 18000,
                'dropshipper_price' => 18000,
                'agen_price' => 17000,
                'distributor_price' => 16000,
                'stok' => 100
            ],
            [
                'slug' => 'jdhfiejo',
                'product_id' => 1,
                'sku' => 004,
                'warna' => 'biru',
                'size' => 'l',
                'price' => 20000,
                'reseller_price' => 18000,
                'dropshipper_price' => 18000,
                'agen_price' => 17000,
                'distributor_price' => 16000,
                'stok' => 100
            ]
        ];

        // Iterasi melalui data dan buat entri
        foreach ($data as $variantData) {
            Variations::create($variantData);
        }
        Logo::create([
            'image'=>'logo/eAwFQfx5KV6TCMLM3SmLjkFDK8Dn6aH6cuesklZl.svg',
            'status'=>'active',
        ]);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
