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
}
