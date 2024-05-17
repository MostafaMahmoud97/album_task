<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use HasFactory;

    protected $fillable = [
        "album_id",
        "name"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function media(){
        return $this->morphOne(Media::class,"mediable");
    }


    public function Album(){
        return $this->belongsTo(Album::class,"album_id","id");
    }
}
