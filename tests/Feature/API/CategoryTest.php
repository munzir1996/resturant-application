<?php

namespace Tests\Feature\API;

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
        Category::factory(2)->create();

        $response = $this->get('/api/categories');

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                ]
            ]
        ]);

    }

    /** @test */
    public function can_get_selected_category()
    {
        $category = Category::factory()->create();

        $response = $this->get('/api/categories/'. $category->id);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
            ]
        ]);

    }

}


