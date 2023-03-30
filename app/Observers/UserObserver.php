<?php

namespace App\Observers;

use App\Models\User; //call user model
use App\Models\Log; // call log model  (model for loging)

class UserObserver
{
    /**
     * Handle the User "creating" event.
     */
    public function creating(User $user)
    {
        $user->last_login = now(); 
        
    }
    /**
     * Handle the User "created" event.
     */
    public function created(User $user)
    {
        //simpan ke dalam tabel log, ini dilakukan setelah user berhasil registrasi
        Log::create([
            'module' => 'register',
            'action' => 'registrasi akun',
            'useraccess' => $user->email

        ]);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user)
    {
        //menyimpan ke dalam tabel Log, ini dilakukan setelah user berhasil disunting
        Log::create([
            'module' => 'sunting',
            'action' => 'sunting akun',
            'useraccess' => $user->email
        ]);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleting(User $user)
    {
        //menyimpan ke dalam tabel log, dilakukan setelah user berhasil di hapus
        Log::create([
            'module' => 'delete',
            'action' => 'delete akun',
            'useraccess' => $user->email
        ]);
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
