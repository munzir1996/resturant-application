<?php

namespace Tests\Feature\API\Client;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_all_categories()
    {
        $this->clientApiLogin();

        Category::factory(2)->create();

        $response = $this->get('/api/client/categories');
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'subcategories'
                ]
            ]
        ]);

    }

    /** @test */
    public function can_get_selected_category()
    {
        $this->clientApiLogin();

        $category = Category::factory()->create();

        $response = $this->get('/api/client/categories/'. $category->id);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'subcategories'
            ]
        ]);

    }

}


