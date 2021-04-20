<?php

namespace Tests\Feature\Company;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListCompanyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());
    }

    /** @test */
    public function can_see_companies_paginated_in_view()
    {
        $this->get('/companies')
            ->assertStatus(200)
            ->assertViewHas('companies', Company::query()->paginate(10));
    }
}
