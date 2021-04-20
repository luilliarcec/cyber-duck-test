<?php

namespace Tests\Feature\Company;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListCompanyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    /** @test */
    public function can_see_companies_paginated_in_view()
    {
        $this->get('/companies')
            ->assertStatus(200)
            ->assertViewHas('companies', Company::query()->paginate(10));
    }
}
