<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function event(){
        return $this->belongsTo(Event::class);
    }
    public function isActive(){
        if((new Carbon($this->event()->date))->format('Y-m-d')>carbon::Now()->format('Y-m-d')){
            return true;
        }
        else{
            return false;
        }
    }
}
