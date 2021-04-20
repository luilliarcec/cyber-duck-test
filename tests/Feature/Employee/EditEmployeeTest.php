<?php

namespace Tests\Feature\Employee;

use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditEmployeeTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
    }

    /** @test */
    public function can_access_to_employee_form_create()
    {
        $this->withoutExceptionHandling();

        $employee = Employee::factory()->create();

        $this->get("/employees/$employee->id/edit")
            ->assertStatus(200)
            ->assertViewHas('companies')
            ->assertSee(['first_name', 'last_name', 'email', 'phone', 'company_id']);
    }

    /** @test */
    public function it_is_validated_that_the_first_name_is_required()
    {
        $employee = Employee::factory()->create();

        $this->from("/employees/$employee->id/edit")
            ->put("/employees/$employee->id")
            ->assertSessionHasErrors(['first_name' => 'The first name field is required.']);

        $this->from("/employees/$employee->id/edit")
            ->put("/employees/$employee->id", ['first_name' => ''])
            ->assertSessionHasErrors(['first_name' => 'The first name field is required.']);

        $this->from("/employees/$employee->id/edit")
            ->put("/employees/$employee->id", ['first_name' => null])
            ->assertSessionHasErrors(['first_name' => 'The first name field is required.']);
    }

    /** @test */
    public function it_is_validated_that_the_last_name_is_required()
    {
        $employee = Employee::factory()->create();

        $this->from("/employees/$employee->id/edit")
            ->put("/employees/$employee->id")
            ->assertSessionHasErrors(['last_name' => 'The last name field is required.']);

        $this->from("/employees/$employee->id/edit")
            ->put("/employees/$employee->id", ['last_name' => ''])
            ->assertSessionHasErrors(['last_name' => 'The last name field is required.']);

        $this->from("/employees/$employee->id/edit")
            ->put("/employees/$employee->id", ['last_name' => null])
            ->assertSessionHasErrors(['last_name' => 'The last name field is required.']);
    }

    /** @test */
    public function it_is_validated_that_the_company_id_is_required()
    {
        $employee = Employee::factory()->create();

        $this->from("/employees/$employee->id/edit")
            ->put("/employees/$employee->id")
            ->assertSessionHasErrors(['company_id' => 'The company field is required.']);

        $this->from("/employees/$employee->id/edit")
            ->put("/employees/$employee->id", ['company_id' => ''])
            ->assertSessionHasErrors(['company_id' => 'The company field is required.']);

        $this->from("/employees/$employee->id/edit")
            ->put("/employees/$employee->id", ['company_id' => null])
            ->assertSessionHasErrors(['company_id' => 'The company field is required.']);
    }

    /** @test */
    public function it_is_validated_that_the_first_name_and_last_name_are_string()
    {
        $employee = Employee::factory()->create();

        $this->from("/employees/$employee->id/edit")
            ->put("/employees/$employee->id", [
                'first_name' => 258,
                'last_name' => 258
            ])
            ->assertSessionHasErrors([
                'first_name' => 'The first name must be a string.',
                'last_name' => 'The last name must be a string.',
            ]);
    }

    /** @test */
    public function it_is_validated_that_the_fields_email_and_phone_are_nullable()
    {
        $employee = Employee::factory()->create();

        $this->from("/employees/$employee->id/edit")
            ->put("/employees/$employee->id")
            ->assertSessionDoesntHaveErrors(['email', 'phone']);
    }

    /** @test */
    public function it_is_validated_that_the_email_is_a_valid_email()
    {
        $employee = Employee::factory()->create();

        $this->from("/employees/$employee->id/edit")
            ->put("/employees/$employee->id", ['email' => 'luilliarcec'])
            ->assertSessionHasErrors(['email' => 'The email must be a valid email address.']);
    }

    /** @test */
    public function it_is_validated_that_the_company_id_is_a_integer()
    {
        $employee = Employee::factory()->create();

        $this->from("/employees/$employee->id/edit")
            ->put("/employees/$employee->id", ['company_id' => 'ada'])
            ->assertSessionHasErrors(['company_id' => 'The company must be an integer.']);
    }

    /** @test */
    public function it_is_validated_that_the_company_id_exists_in_companies_table()
    {
        $employee = Employee::factory()->create();

        $this->from("/employees/$employee->id/edit")
            ->put("/employees/$employee->id", ['company_id' => 28])
            ->assertSessionHasErrors(['company_id' => 'The selected company is invalid.']);
    }

    /** @test */
    public function it_is_validated_that_the_all_fields_are_less_to_255_chars()
    {
        $employee = Employee::factory()->create();

        $longText = $this->faker->realTextBetween(256, 300);

        $this->from("/employees/$employee->id/edit")
            ->put("/employees/$employee->id", [
                'first_name' => $longText,
                'last_name' => $longText,
                'email' => $longText . '@email.com',
                'phone' => $longText,
            ])
            ->assertSessionHasErrors([
                'first_name' => 'The first name must not be greater than 255 characters.',
                'last_name' => 'The last name must not be greater than 255 characters.',
                'email' => 'The email must not be greater than 255 characters.',
                'phone' => 'The phone must not be greater than 255 characters.',
            ]);
    }

    /** @test */
    public function save_employee()
    {
        $employee = Employee::factory()->create();

        $company = Company::factory()->create();

        $this->from("/employees/$employee->id/edit")
            ->put("/employees/$employee->id", [
                'first_name' => 'Luis',
                'last_name' => 'Arce',
                'company_id' => $company->id,
                'email' => 'luilliarcec@gmail.com',
                'phone' => '0960603626',
            ])
            ->assertRedirect("/employees/$employee->id/edit")
            ->assertSessionHasNoErrors()
            ->assertSessionHas('response', __('response.success.edit'));

        $this->assertDatabaseHas('employees', [
            'first_name' => 'Luis',
            'last_name' => 'Arce',
            'company_id' => $company->id,
            'email' => 'luilliarcec@gmail.com',
            'phone' => '0960603626',
        ]);
    }
}
