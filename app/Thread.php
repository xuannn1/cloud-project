<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = [
        'title', 'body', 'category_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }
}
