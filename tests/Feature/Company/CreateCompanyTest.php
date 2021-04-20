<?php

namespace Tests\Feature\Company;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCompanyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_access_to_company_form_create()
    {
        $this->withoutExceptionHandling();

        $this->get('/companies/create')
            ->assertStatus(200)
            ->assertSee(['name', 'email', 'website', 'logo']);
    }
}
