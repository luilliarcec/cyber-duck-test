<?php

namespace Tests\Feature\Company;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
}
