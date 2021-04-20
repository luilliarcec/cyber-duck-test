<?php

namespace Tests\Feature\Employee;

use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListEmployeeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());
    }

    /** @test */
    public function can_see_employees_paginated_in_view()
    {
        $this->get('/employees')
            ->assertStatus(200)
            ->assertViewHas('employees', Employee::query()->paginate(10));
    }
}
