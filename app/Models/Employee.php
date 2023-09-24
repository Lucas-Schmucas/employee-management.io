<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'username',
        'prefix',
        'firstname',
        'middle_initial',
        'lastname',
        'gender',
        'email',
        'date_of_birth', // Maybe store together with time
        'time_of_birth',
        'date_of_joining',
        'phone_number',
    ];

    public function address()  : HasOneOrMany
    {
        return $this->hasMany(Address::class);
    }
}
