<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Emp ID' => $this->id,
            'User Name' => $this->username,
            'Name Prefix' => $this->prefix,
            'First Name' => $this->firstname,
            'Middle Initial' => $this->middle_initial,
            'Last Name' => $this->lastname,
            'Gender' => $this->gender,
            'E Mail' => $this->email,
            'Date of Birth' => $this->data_of_birth,
            'Time of Birth' => $this->time_of_birth,
            'Age in Yrs.' => $this->age_in_years,
            'Date of Joining' => $this->date_of_joining,
            'Age in Company (Years)' => $this->age_in_company,
            'Phone No. ' => $this->phone_number,
            'Country' => $this->address->country,
            'Place Name' => $this->address->street,
            'City' => $this->address->street,
            'Zip' => $this->address->zip,
            'Region' => $this->address->region,
        ];
    }
}
