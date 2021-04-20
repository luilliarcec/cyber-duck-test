<?php

namespace Tests\Feature\Company;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCompanyTest extends TestCase
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
        $company = Company::factory()->create();

        $this->from('/companies')
            ->delete("/companies/$company->id")
            ->assertRedirect('/companies')
            ->assertSessionHas('response', __('response.success.delete'));
    }
}
