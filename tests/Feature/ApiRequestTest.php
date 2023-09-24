<?php


namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ApiRequestTest extends TestCase
{
    use DatabaseTransactions;

    public function test_employee_create()
    {
        // "curl -X POST -H 'Content-Type: text/csv' -d @smallImport.csv http://127.0.10.1:7777/api/employee";

        $file = file_get_contents('./tests/smallImport.csv');

        $response = $this->post('/api/employee', ['file' => $file], ['Content-Type' => 'text/csv']);

        $response->assertStatus(201);

        $response->assertJson([
            'created' => true,
        ]);
        $this->assertDatabaseCount('employees', 2);

        $this->assertDatabaseHas('employees', [
            'email' => 'avelina.stoner@exxonmobil.com' // random pick
        ]);

    }
}
