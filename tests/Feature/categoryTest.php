<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class categoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_categories_get(): void
    {
        $response = $this->get('/api/categories');
        $response->assertJsonStructure([
            '*' => [
                "id",
                "name",
                "created_at",
                "updated_at",
                "created_by",
                "updated_by",
                "deleted_by"
            ]
        ]);
        $response->assertStatus(200);
    }
}
