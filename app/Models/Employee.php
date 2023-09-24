<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

class Employee extends Model
{
    use HasFactory;

    protected $casts = [
        'date_of_birth' => 'datetime:Y-m-d',
    ];
    protected $appends = [
        'age_in_years',
        'age_in_company'
    ];

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

    public function address(): HasOneOrMany
    {
        return $this->hasMany(Address::class);
    }

    protected function timeOfBirth(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => Carbon::createFromFormat('H:i:s', $value)->format('h:i:s A'),
            set: fn(string $value) => Carbon::createFromFormat('h:i:s A', $value)->format('H:i:s'),
        );
    }

    protected function dateOfBirth(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => Carbon::createFromFormat('Y-m-d', $value)->format('m/d/Y'),
            set: fn(string $value) => Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d'),
        );
    }

    protected function dateOfJoining(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => Carbon::createFromFormat('Y-m-d', $value)->format('m/d/Y'),
            set: fn(string $value) => Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d'),
        );
    }
}
