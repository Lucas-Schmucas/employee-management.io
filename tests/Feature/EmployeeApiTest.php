<?php


namespace Tests\Feature;

use App\Models\Address;
use App\Models\Employee;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class EmployeeApiTest extends TestCase
{
    use DatabaseTransactions;

    public function test_store(): void
    {
        // "curl -X POST -H 'Content-Type: text/csv' -d @smallImport.csv http://127.0.10.1:7777/api/employee";

        $file = file_get_contents('./tests/smallImport.csv');

        $response = $this->post('/api/employee', ['file' => $file], ['Content-Type' => 'text/csv']);

        $response->assertStatus(201);

        $response->assertJson(fn(AssertableJson $json) => $json
            ->has('data', fn(AssertableJson $json) => $json
                ->first(fn(AssertableJson $json) => $json
                    ->where('First Name', 'Chas')
                    ->etc()
                )->etc()
            )->has('created')
        );

        $this->assertDatabaseCount('employees', 2);

        $this->assertDatabaseHas('employees', [
            'email' => 'chas.hurdle@gmail.com' // random pick from smallInput.csv
        ]);
    }

    public function test_store_with_broken_data(): void
    {
        $file = file_get_contents('./tests/brokenImport.csv'); // brokenImport has an ID with letters

        $response = $this->post('/api/employee', ['file' => $file], ['Content-Type' => 'text/csv']);

        $response->assertStatus(500);

        $this->assertDatabaseCount('employees', 0); // none of the data is stored, even if one row is broken

    }

    public function test_show(): void
    {
        $employee = Employee::create([
            'username' => fake()->userName,
            'prefix' => fake()->title,
            'firstname' => fake()->firstName,
            'middle_initial' => fake()->randomLetter,
            'lastname' => fake()->lastName,
            'gender' => fake()->randomElement(['m', 'w', 'd']),
            'email' => fake()->email,
            'date_of_birth' => fake()->date('m/d/Y', 'last century'),
            'date_of_joining' => fake()->date('m/d/Y', 'last decade'),
            'time_of_birth' => fake()->time('h:i:s A'),
            'phone_number' => fake()->phoneNumber,
        ]);
        $address = new Address([
            'employee_id' => $employee->id,
            'street' => fake()->streetName,
            'city' => fake()->city,
            'zip' => fake()->postcode,
            'region' => fake()->citySuffix,
            'country' => fake()->streetName,
        ]);
        $employee->address()->save($address);

        $response = $this->get('/api/employee/' . $employee->id);

        $response->assertStatus(200);
        $response->assertJson(fn(AssertableJson $json) => $json
            ->has('data', fn(AssertableJson $json) => $json
                ->has('First Name')
                ->etc()
            )->has('created')
        );
    }

}
