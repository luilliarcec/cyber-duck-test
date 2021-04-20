<?php

namespace Tests\Feature\Company;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EditCompanyTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function can_access_to_company_form_cedit()
    {
        $this->withoutExceptionHandling();

        $company = Company::factory()->create();

        $this->get("/companies/$company->id/edit")
            ->assertStatus(200)
            ->assertSee(['name', 'email', 'website', 'logo'])
            ->assertViewHas('company', $company);
    }

     /** @test */
    public function it_is_validated_that_the_name_is_required()
    {
        $company = Company::factory()->create();

        $this->from("/companies/$company->id/edit")
            ->put("/companies/$company->id")
            ->assertSessionHasErrors(['name' => 'The name field is required.']);

        $this->from("/companies/$company->id/edit")
            ->put("/companies/$company->id", ['name' => ''])
            ->assertSessionHasErrors(['name' => 'The name field is required.']);

        $this->from("/companies/$company->id/edit")
            ->put("/companies/$company->id", ['name' => null])
            ->assertSessionHasErrors(['name' => 'The name field is required.']);
    }

    /** @test */
    public function it_is_validated_that_the_name_is_a_string()
    {
        $company = Company::factory()->create();

        $this->from("/companies/$company->id/edit")
            ->put("/companies/$company->id", ['name' => 258])
            ->assertSessionHasErrors(['name' => 'The name must be a string.']);
    }

    /** @test */
    public function it_is_validated_that_the_fields_email_website_and_logo_are_nullable()
    {
        $company = Company::factory()->create();

        $this->from("/companies/$company->id/edit")
            ->put("/companies/$company->id")
            ->assertSessionHasErrors('name')
            ->assertSessionDoesntHaveErrors(['email', 'website', 'logo']);
    }

    /** @test */
    public function it_is_validated_that_the_email_is_a_valid_email()
    {
        $company = Company::factory()->create();

        $this->from("/companies/$company->id/edit")
            ->put("/companies/$company->id", ['email' => 'luilliarcec'])
            ->assertSessionHasErrors(['email' => 'The email must be a valid email address.']);
    }

    /** @test */
    public function it_is_validated_that_the_website_is_a_valid_url()
    {
        $company = Company::factory()->create();

        $this->from("/companies/$company->id/edit")
            ->put("/companies/$company->id", ['website' => 'luilliarcec'])
            ->assertSessionHasErrors(['website' => 'The website format is invalid.']);
    }

    /** @test */
    public function it_is_validated_that_the_logo_is_a_image()
    {
        $company = Company::factory()->create();

        $this->from("/companies/$company->id/edit")
            ->put("/companies/$company->id", ['logo' => 'luilliarcec'])
            ->assertSessionHasErrors(['logo' => 'The logo must be an image.']);
    }

    /** @test */
    public function it_is_validated_that_the_logo_is_a_image_with_100_x_100()
    {
        $company = Company::factory()->create();

        $this->from("/companies/$company->id/edit")
            ->put("/companies/$company->id", ['logo' => UploadedFile::fake()->image('logo.jpg', 99, 99)])
            ->assertSessionHasErrors(['logo' => 'The logo has invalid image dimensions.']);
    }

    /** @test */
    public function it_is_validated_that_the_all_fields_are_less_to_255_chars()
    {
        $company = Company::factory()->create();

        $longText = $this->faker->realTextBetween(256, 300);

        $this->from("/companies/$company->id/edit")
            ->put("/companies/$company->id", [
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
        $company = Company::factory()->create();

        $this->from("/companies/$company->id/edit")
            ->put("/companies/$company->id", [
                'name' => 'Cyber Duck',
                'email' => 'cyber-duck@email.com',
                'website' => 'https://www.cyber-duck.com',
            ])
            ->assertRedirect("/companies/$company->id/edit")
            ->assertSessionHasNoErrors()
            ->assertSessionHas('response', __('response.success.edit'));

        $this->assertDatabaseHas('companies', [
            'name' => 'Cyber Duck',
            'email' => 'cyber-duck@email.com',
            'website' => 'https://www.cyber-duck.com',
        ]);
    }

    /** @test */
    public function save_company_with_image()
    {
        $company = Company::factory()->create();

        $this->from("/companies/$company->id/edit")
            ->put("/companies/$company->id", [
                'name' => 'Cyber Duck',
                'email' => 'cyber-duck@email.com',
                'website' => 'https://www.cyber-duck.com',
                'logo' => UploadedFile::fake()->image('cyber-duck.jpg', 120, 120),
            ])
            ->assertRedirect("/companies/$company->id/edit")
            ->assertSessionHasNoErrors()
            ->assertSessionHas('response', __('response.success.edit'));

        $this->assertDatabaseHas('companies', [
            'name' => 'Cyber Duck',
            'email' => 'cyber-duck@email.com',
            'website' => 'https://www.cyber-duck.com',
        ]);

        $company->refresh();

        Storage::disk('public')->assertExists(
            explode('/', $company->logo)[1]
        );
    }
}
