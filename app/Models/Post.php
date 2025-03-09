<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'content', 
        'media',
        'categoria_id',
        'group_id'
    ];

    protected $casts = [
        'categoria_id' => 'integer',
        'group_id' => 'integer',
    ];
    


    public function user(){
        return $this->BelongsTo(User::class);
    }

    public function reaccions(){
        return $this->hasMany(Reaccion::class);
    }
    public function reposts()
    {
        return $this->hasMany(Repost::class);
    }

    public function media(){
        return $this->hasMany(Media::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
