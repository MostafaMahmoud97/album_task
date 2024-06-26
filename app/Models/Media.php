<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $appends = ["file_path"];
    protected $fillable = [
        'id',
        'mediable_type',
        'mediable_id',
        'title',
        'type',
        'directory',
        'filename'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function mediable(){
        return $this->morphTo();
    }

    public function getFilePathAttribute(){
        return asset('files/'.$this->directory.$this->filename);
    }
}
