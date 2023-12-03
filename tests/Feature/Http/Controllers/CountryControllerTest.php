<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CountryController
 */
final class CountryControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $countries = Country::factory()->count(3)->create();

        $response = $this->get(route('country.index'));

        $response->assertOk();
        $response->assertViewIs('country.index');
        $response->assertViewHas('countries');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('country.create'));

        $response->assertOk();
        $response->assertViewIs('country.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CountryController::class,
            'store',
            \App\Http\Requests\CountryStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $name = $this->faker->name();
        $code = $this->faker->word();

        $response = $this->post(route('country.store'), [
            'name' => $name,
            'code' => $code,
        ]);

        $countries = Country::query()
            ->where('name', $name)
            ->where('code', $code)
            ->get();
        $this->assertCount(1, $countries);
        $country = $countries->first();

        $response->assertRedirect(route('country.index'));
        $response->assertSessionHas('country.id', $country->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $country = Country::factory()->create();

        $response = $this->get(route('country.show', $country));

        $response->assertOk();
        $response->assertViewIs('country.show');
        $response->assertViewHas('country');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $country = Country::factory()->create();

        $response = $this->get(route('country.edit', $country));

        $response->assertOk();
        $response->assertViewIs('country.edit');
        $response->assertViewHas('country');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CountryController::class,
            'update',
            \App\Http\Requests\CountryUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $country = Country::factory()->create();
        $name = $this->faker->name();
        $code = $this->faker->word();

        $response = $this->put(route('country.update', $country), [
            'name' => $name,
            'code' => $code,
        ]);

        $country->refresh();

        $response->assertRedirect(route('country.index'));
        $response->assertSessionHas('country.id', $country->id);

        $this->assertEquals($name, $country->name);
        $this->assertEquals($code, $country->code);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $country = Country::factory()->create();

        $response = $this->delete(route('country.destroy', $country));

        $response->assertRedirect(route('country.index'));

        $this->assertModelMissing($country);
    }
}
