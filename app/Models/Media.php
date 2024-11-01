<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'type'
    ];

    protected $casts = [
        'editado' => 'boolean',
    ];

    public function post(){
        return $this->belongsTo(Post::class);
    }
}
