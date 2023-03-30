<?php

namespace App\Observers;

use App\Models\Ingredient;
use App\Models\Log;

class IngredientObserver
{
    /**
     * Handle the Ingredient "created" event.
     */
    public function created(Ingredient $ingredient): void
    {
        //
        Log::create([
            'module' => 'tambah bahan',
            'action' => 'tambah bahan untuk id resep'.$ingredient->resep_idresep.'dengan bahan'. $ingredient->nama,
            'useraccess' => '_'    //kita bisa trace ini dari log module tambah resep

        ]);
    }

    /**
     * Handle the Ingredient "updated" event.
     */
    public function updated(Ingredient $ingredient): void
    {
        //
    }

    /**
     * Handle the Ingredient "deleted" event.
     */
    public function deleting(Ingredient $ingredient)
    {
        //
        Log::create([
            'module' => 'hapus bahan',
            'action' => 'hapus bahan untuk id resep'.$ingredient->resep_idresep,
            'useraccess' => "_"

        ]);
        
        

    }

    /**
     * Handle the Ingredient "restored" event.
     */
    public function restored(Ingredient $ingredient): void
    {
        //
    }

    /**
     * Handle the Ingredient "force deleted" event.
     */
    public function forceDeleted(Ingredient $ingredient): void
    {
        //
    }
}
