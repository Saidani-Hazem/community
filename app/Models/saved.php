<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class saved extends Model
{
    /** @use HasFactory<\Database\Factories\SavedFactory> */
    use HasFactory;



    public function user(){
        return $this->belongsTo(user::class);
    }

    public function post(){
        return $this->belongsTo(post::class);
    }

}
