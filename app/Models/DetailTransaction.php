<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailTransaction extends Model
{
    protected $guarded = [
        'id'
    ];
    use HasFactory;
    /**
     * Get the product that owns the DetailTransaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function variations(): BelongsTo
    {
        return $this->belongsTo(Variations::class, 'variations_id', 'id');
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    /**
     * Get the transaction that owns the DetailTransaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }
}
