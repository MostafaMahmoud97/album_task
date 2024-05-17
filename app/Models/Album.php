<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        "name"
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];

    public function SinglePicture(){
        return $this->hasOne(Picture::class,"album_id","id");
    }

    public function Pictures(){
        return $this->hasMany(Picture::class,"album_id","id");
    }
}
