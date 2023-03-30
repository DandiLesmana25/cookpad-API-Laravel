<?php

namespace App\Observers;

use App\Models\Tool;
use App\Models\Log;

class ToolObserver
{
    /**
     * Handle the Tool "created" event.
     */
    public function created(Tool $tool)
    {
        //
        Log::create([
            'module' => 'tambah alat',
            'action' => 'tambah alat untuk id resep'.$tool->resep_idresep.'dengan nama alat'. $tool->nama_alat,
            'useraccess' => '_'    //kita bisa trace ini dari log module tambah resep

        ]);
    }

    /**
     * Handle the Tool "updated" event.
     */
    public function updated(Tool $tool): void
    {
        //
    }

    /**
     * Handle the Tool "deleted" event.
     */
    public function deleting(Tool $tool)
    {
        //
        Log::create([
            'module' => 'hapus alat',
            'action' => 'hapus alat untuk id resep'.$tool->resep_idresep,
            'useraccess' => "_"

        ]);
        
    }

    /**
     * Handle the Tool "restored" event.
     */
    public function restored(Tool $tool): void
    {
        //
    }

    /**
     * Handle the Tool "force deleted" event.
     */
    public function forceDeleted(Tool $tool): void
    {
        //
    }
}
