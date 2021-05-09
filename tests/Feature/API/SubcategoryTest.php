<?php

namespace Tests\Feature\API;

use App\Models\Subcategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubcategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_all_subcategories()
    {

        Subcategory::factory(2)->create();

        $response = $this->get('/api/subcategories');

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'category_id',
                ]
            ]
        ]);
    }

    /** @test */
    public function can_get_selected_subcategory()
    {
        $subcategory = Subcategory::factory()->create();
        $response = $this->get('/api/subcategories/'. $subcategory->id);

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'category_id',
            ]
        ]);
    }


}



