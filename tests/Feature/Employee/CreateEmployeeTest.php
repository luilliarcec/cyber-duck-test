<?php

namespace Tests\Feature\Employee;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateEmployeeTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function can_access_to_employee_form_create()
    {
        $this->withoutExceptionHandling();

        $this->get('/employees/create')
            ->assertStatus(200)
            ->assertViewHas('companies')
            ->assertSee(['first_name', 'last_name', 'email', 'phone', 'company_id']);
    }
}
