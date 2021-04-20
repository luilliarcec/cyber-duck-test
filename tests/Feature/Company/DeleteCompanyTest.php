<?php

namespace Tests\Feature\Company;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCompanyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());
    }

    /** @test */
    public function can_delete_company()
    {
        $company = Company::factory()->create();

        $this->from('/companies')
            ->delete("/companies/$company->id")
            ->assertRedirect('/companies')
            ->assertSessionHas('response', __('response.success.delete'));
    }
}
