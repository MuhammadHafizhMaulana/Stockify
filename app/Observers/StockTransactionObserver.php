<?php

namespace App\Observers;

use App\Models\StockTransaction;

class StockTransactionObserver
{
    /**
     * Handle the StockTransaction "created" event.
     */
    public function created(StockTransaction $stockTransaction): void
    {
        //
    }

    /**
     * Handle the StockTransaction "updated" event.
     */
    public function updated(StockTransaction $stockTransaction): void
    {
        // hanya kalo status baru = diterima / tidak diterima
        if($stockTransaction->isDirty('status') && $stockTransaction->status === 'diterima'){
            $product = $stockTransaction->product;

            if($stockTransaction->type === 'masuk'){
                $product->increment('current_stock', $stockTransaction->quantity);
            }
            if($stockTransaction->type === 'keluar'){
                $product->decrement('current_stock', $stockTransaction->quantity);
            }
        }
    }

    /**
     * Handle the StockTransaction "deleted" event.
     */
    public function deleted(StockTransaction $stockTransaction): void
    {
        //
    }

    /**
     * Handle the StockTransaction "restored" event.
     */
    public function restored(StockTransaction $stockTransaction): void
    {
        //
    }

    /**
     * Handle the StockTransaction "force deleted" event.
     */
    public function forceDeleted(StockTransaction $stockTransaction): void
    {
        //
    }
}
