<?php

namespace Tests\Feature\API\Client;

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

        $this->clientApiLogin();

        Subcategory::factory(2)->create();

        $response = $this->get('/api/client/subcategories');
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
        $this->clientApiLogin();

        $subcategory = Subcategory::factory()->create();

        $response = $this->get('/api/client/subcategories/'. $subcategory->id);
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



