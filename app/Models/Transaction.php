<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    protected $guarded = [];
    use HasFactory;

    /**
     * Get the pelanggan that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id', 'id');
    }
    public function drop(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'dropshipper_id', 'id');
    }
    /**
     * Get the commission that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comission(): BelongsTo
    {
        return $this->belongsTo(Comission::class, 'id', 'transaction_id');
    }
    /**
     * Get all of the detran for the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detran(): HasMany
    {
        return $this->hasMany(DetailTransaction::class, 'transaksi_id', 'id');
    }
}
