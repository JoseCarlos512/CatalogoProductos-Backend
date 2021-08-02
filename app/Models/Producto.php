<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = "productos"; // Con que tabla va a trabajar

    protected $fillable = [ // La clase producto trabajara con estos campos
        "codigo",
        "nombre",
        "descripcion",
        "precio",
        "url_imagen",
        "like",
        "dislike",
        "user_id"
    ];

    protected $hidden =  ['created_at', 'updated_at'];

    //relaciones clase producto tieneun solo usuario
    public function user() {
        return $this->belongsTo(User::class);
    }
}
