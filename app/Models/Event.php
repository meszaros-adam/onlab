<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'date', 'name', 'description', 'headcount', 'location', 'google_maps_iframe'];

    protected $appends = ['free_seats'];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
    public function tags()
    {
        return $this->hasMany(Tag::class, 'blogtag');
    }
    public function creator()
    {
        return $this->belongsTo(User::class);
    }
    public function getFreeSeatsAttribute()
    {
        $reservedSeats = $this->registrations->sum('headcount');

        return $this->headcount-$reservedSeats;

    }
}
