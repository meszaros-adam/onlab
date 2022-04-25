<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

   public function registrations(){
       return $this->hasMany(Registration::class);
   }
   public function tags(){
       return $this->hasMany(Tag::class, 'blogtag');
   }
   public function creator(){
       return $this->belongsTo(User::class);
   }
}
