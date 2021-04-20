<?php

namespace Tests\Feature\Employee;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteEmployeeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    /** @test */
    public function can_delete_company()
    {
        $employee = Employee::factory()->create();

        $this->from('/employees')
            ->delete("/employees/$employee->id")
            ->assertRedirect('/employees')
            ->assertSessionHas('response', __('response.success.delete'));
    }
}
