<?php


namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ApiRequestTest extends TestCase
{
    use DatabaseTransactions;

    public function test_employee_post_api()
    {
        // "curl -X POST -H 'Content-Type: text/csv' -d @import.csv http://employee-management.io/api/employee";

        $file = file_get_contents('./tests/import.csv');

        $response = $this->postJson('/api/employees', [$file], [
            'Content-Type' => 'text/csv',
        ]);

        $response->assertStatus(201);

        $response->assertJson([
            'created' => true,
        ]);
        $this->assertDatabaseCount('employees', 10001);

        $this->assertDatabaseHas('employees', [
            'email' => 'avelina.stoner@exxonmobil.com' // random pick
        ]);

    }
}
