<?php

namespace Tests\Feature\Employee;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateEmployeeTest extends TestCase
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

        $this->get('/employees/create')
            ->assertStatus(200)
            ->assertViewHas('companies')
            ->assertSee(['first_name', 'last_name', 'email', 'phone', 'company_id']);
    }

    /** @test */
    public function it_is_validated_that_the_first_name_is_required()
    {
        $this->from('/employees/create')
            ->post('/employees')
            ->assertSessionHasErrors(['first_name' => 'The first name field is required.']);

        $this->from('/employees/create')
            ->post('/employees', ['first_name' => ''])
            ->assertSessionHasErrors(['first_name' => 'The first name field is required.']);

        $this->from('/employees/create')
            ->post('/employees', ['first_name' => null])
            ->assertSessionHasErrors(['first_name' => 'The first name field is required.']);
    }

    /** @test */
    public function it_is_validated_that_the_last_name_is_required()
    {
        $this->from('/employees/create')
            ->post('/employees')
            ->assertSessionHasErrors(['last_name' => 'The last name field is required.']);

        $this->from('/employees/create')
            ->post('/employees', ['last_name' => ''])
            ->assertSessionHasErrors(['last_name' => 'The last name field is required.']);

        $this->from('/employees/create')
            ->post('/employees', ['last_name' => null])
            ->assertSessionHasErrors(['last_name' => 'The last name field is required.']);
    }

    /** @test */
    public function it_is_validated_that_the_company_id_is_required()
    {
        $this->from('/employees/create')
            ->post('/employees')
            ->assertSessionHasErrors(['company_id' => 'The company field is required.']);

        $this->from('/employees/create')
            ->post('/employees', ['company_id' => ''])
            ->assertSessionHasErrors(['company_id' => 'The company field is required.']);

        $this->from('/employees/create')
            ->post('/employees', ['company_id' => null])
            ->assertSessionHasErrors(['company_id' => 'The company field is required.']);
    }

    /** @test */
    public function it_is_validated_that_the_first_name_and_last_name_are_string()
    {
        $this->from('/employees/create')
            ->post('/employees', [
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
        $this->from('/employees/create')
            ->post('/employees')
            ->assertSessionDoesntHaveErrors(['email', 'phone']);
    }

    /** @test */
    public function it_is_validated_that_the_email_is_a_valid_email()
    {
        $this->from('/employees/create')
            ->post('/employees', ['email' => 'luilliarcec'])
            ->assertSessionHasErrors(['email' => 'The email must be a valid email address.']);
    }

    /** @test */
    public function it_is_validated_that_the_company_id_is_a_integer()
    {
        $this->from('/employees/create')
            ->post('/employees', ['company_id' => 'ada'])
            ->assertSessionHasErrors(['company_id' => 'The company must be an integer.']);
    }

    /** @test */
    public function it_is_validated_that_the_company_id_exists_in_companies_table()
    {
        $this->from('/employees/create')
            ->post('/employees', ['company_id' => 28])
            ->assertSessionHasErrors(['company_id' => 'The selected company is invalid.']);
    }

    /** @test */
    public function it_is_validated_that_the_all_fields_are_less_to_255_chars()
    {
        $longText = $this->faker->realTextBetween(256, 300);

        $this->from('/employees/create')
            ->post('/employees', [
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
        $company = Company::factory()->create();

        $this->from('/employees/create')
            ->post('/employees', [
                'first_name' => 'Luis',
                'last_name' => 'Arce',
                'company_id' => $company->id,
                'email' => 'luilliarcec@gmail.com',
                'phone' => '0960603626',
            ])
            ->assertRedirect('/employees/create')
            ->assertSessionHasNoErrors()
            ->assertSessionHas('response', __('response.success.create'));

        $this->assertDatabaseHas('employees', [
            'first_name' => 'Luis',
            'last_name' => 'Arce',
            'company_id' => $company->id,
            'email' => 'luilliarcec@gmail.com',
            'phone' => '0960603626',
        ]);
    }
}
