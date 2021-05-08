<?php
namespace Tests\Feature\API;

use App\Models\Language;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LanguageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_all_languages()
    {

        Language::factory(2)->create();

        $response = $this->get('/api/languages');

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'key',
                    'code',
                ]
            ]
        ]);

    }

    /** @test */
    public function can_get_selected_language()
    {

        $language = Language::factory()->create();

        $response = $this->get('/api/languages/'. $language->id);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'key',
                'code',
            ]
        ]);

    }

}




