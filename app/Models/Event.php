<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
    public function reserved_childs(){

        $registrations=$this->registrations;

        $reserved_childs=0;

        foreach ($registrations as $registration)
        {
        $reserved_childs+=$registration->child_headcount;
        }
        return $reserved_childs;
    }
    public function reserved_adults(){

        $registrations=$this->registrations;

        $reserved_adults=0;

        foreach ($registrations as $registration)
        {
        $reserved_adults+=$registration->adult_headcount;
        }
        return $reserved_adults;
    }
    public function reserved_total(){
        return $this->reserved_adults+$this->reserved_childs;
    }
}
