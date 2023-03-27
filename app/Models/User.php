<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasFactory, Notifiable;
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'email_validate',
        'status',
        'last_login'
    ];
    //note:Pada variabel fillable kita tidak memasukkan kolom created_at dan updated_at, hal ini
// dikarenakan 2 kolom tersebut akan otomatis terisi apabila kita melakukan tambah data atau
// sunting data.


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($password) 
    {
        $this->attributes['password'] = bcrypt($password);            //untuk nge ecrypt password
    }

    // public function recipe()
    // {}

    /**
     * untuk relasi ke tabwk resep
     */
    public function recipe()
    {
        //relasi ke table recipe dengan forgein key user_email pada tabel resep
        //dan key utama email pada table user
        return $this->hasMany(Recipe::class, 'user_email', 'email');
    }

}    
