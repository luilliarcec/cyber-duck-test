<?php

namespace Tests\Feature\Company;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CreateCompanyTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function can_access_to_company_form_create()
    {
        $this->withoutExceptionHandling();

        $this->get('/companies/create')
            ->assertStatus(200)
            ->assertSee(['name', 'email', 'website', 'logo']);
    }

    /** @test */
    public function it_is_validated_that_the_name_is_required()
    {
        $this->from('/companies/create')
            ->post('/companies')
            ->assertSessionHasErrors(['name' => 'The name field is required.']);

        $this->from('/companies/create')
            ->post('/companies', ['name' => ''])
            ->assertSessionHasErrors(['name' => 'The name field is required.']);

        $this->from('/companies/create')
            ->post('/companies', ['name' => null])
            ->assertSessionHasErrors(['name' => 'The name field is required.']);
    }

    /** @test */
    public function it_is_validated_that_the_name_is_a_string()
    {
        $this->from('/companies/create')
            ->post('/companies', ['name' => 258])
            ->assertSessionHasErrors(['name' => 'The name must be a string.']);
    }

    /** @test */
    public function it_is_validated_that_the_fields_email_website_and_logo_are_nullable()
    {
        $this->from('/companies/create')
            ->post('/companies')
            ->assertSessionHasErrors('name')
            ->assertSessionDoesntHaveErrors(['email', 'website', 'logo']);
    }

    /** @test */
    public function it_is_validated_that_the_email_is_a_valid_email()
    {
        $this->from('/companies/create')
            ->post('/companies', ['email' => 'luilliarcec'])
            ->assertSessionHasErrors(['email' => 'The email must be a valid email address.']);
    }

    /** @test */
    public function it_is_validated_that_the_website_is_a_valid_url()
    {
        $this->from('/companies/create')
            ->post('/companies', ['website' => 'luilliarcec'])
            ->assertSessionHasErrors(['website' => 'The website format is invalid.']);
    }

    /** @test */
    public function it_is_validated_that_the_logo_is_a_image()
    {
        $this->from('/companies/create')
            ->post('/companies', ['logo' => 'luilliarcec'])
            ->assertSessionHasErrors(['logo' => 'The logo must be an image.']);
    }

    /** @test */
    public function it_is_validated_that_the_logo_is_a_image_with_100_x_100()
    {
        $this->from('/companies/create')
            ->post('/companies', ['logo' => UploadedFile::fake()->image('logo.jpg', 101, 101)])
            ->assertSessionHasErrors(['logo' => 'The logo has invalid image dimensions.']);
    }

    /** @test */
    public function it_is_validated_that_the_all_fields_are_less_to_255_chars()
    {
        $longText = $this->faker->realTextBetween(256, 300);

        $this->from('/companies/create')
            ->post('/companies', [
                'name' => $longText,
                'email' => $longText . '@email.com',
                'website' => 'www.' . $longText . '.com',
            ])
            ->assertSessionHasErrors([
                'name' => 'The name must not be greater than 255 characters.',
                'email' => 'The email must not be greater than 255 characters.',
                'website' => 'The website must not be greater than 255 characters.',
            ]);
    }

    /** @test */
    public function save_company_without_image()
    {
        $this->from('/companies/create')
            ->post('/companies', [
                'name' => 'Cyber Duck',
                'email' => 'cyber-duck@email.com',
                'website' => 'https://www.cyber-duck.com',
            ])
            ->assertRedirect('/companies/create')
            ->assertSessionHasNoErrors()
            ->assertSessionHas('response', __('response.success.create'));

        $this->assertDatabaseHas('companies', [
            'name' => 'Cyber Duck',
            'email' => 'cyber-duck@email.com',
            'website' => 'https://www.cyber-duck.com',
        ]);
    }
}
