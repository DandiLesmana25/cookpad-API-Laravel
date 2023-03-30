<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $table = 'resep';
    
    protected $fillable = ['judul','gambar','cara_pembuatan','video','user_email','status_resep'];
    

    /**
     * Get the user te Recipe
     *
     * @ren \Illuminate\Database\Eloquent\Ruser_emaillemail*/
    //relasi ke tabel user
    public function user()
    {
        //             Milik
        return $this->belongsTo(User::class,'user_email','email');
    }
    
}
