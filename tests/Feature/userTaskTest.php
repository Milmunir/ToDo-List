<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class userTaskTest extends TestCase
{
    public function test_submit_new_task(): void
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'jd@jd.com',
            'username' => 'jd',
        ];
        $taskData = [
            ['category_id' => 1, 'description' => 'johndoeishere1'],
            ['category_id' => 2, 'description' => 'johndoeishere2'],
            ['category_id' => 1, 'description' => 'johndoewashere1'],
        ];
        $response = $this->postJson('/api/task', array_merge($userData, ['task' => $taskData]));
        $response->assertJsonStructure([
            "newuser" => [
                "id",
                "name",
                "username",
                "email",
                "updated_at",
                "created_at"
            ],
            "newtask" => [
                "*" => [
                    "id",
                    "category_id",
                    "description",
                    "created_by",
                    "user_id",
                    "updated_at",
                    "created_at",
                ]
            ]
        ]);
        $response->assertStatus(201);
    }

    public function test_user_validation_error(): void
    {
        $userData = [
            'name' => '',
            'email' => '',
            'username' => '',
        ];
        $taskData = [
            ['category_id' => 1, 'description' => 'johndoeishere1'],
            ['category_id' => 2, 'description' => 'johndoeishere2'],
            ['category_id' => 1, 'description' => 'johndoewashere1'],
        ];
        $response = $this->postJson('/api/task', array_merge($userData, ['task' => $taskData]));
        $response->assertJsonStructure([
            "error",
            "messages" => [
                "name",
                "email",
                "username"
            ]
        ]);
        $response->assertStatus(422);
    }

    public function test_task_validation_error(): void
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'jd@jd.com',
            'username' => 'jd',
        ];
        $taskData = [
            ['category_id' => 1, 'description' => ''],
            ['category_id' => '', 'description' => 'johndoeishere2'],
            ['category_id' => 1, 'description' => 'johndoewashere1'],
        ];
        $response = $this->postJson('/api/task', array_merge($userData, ['task' => $taskData]));
        $response->assertJsonStructure([
            "error",
            "messages" => [
                "task.0.description",
                "task.1.category_id"
            ]
        ]);
        $response->assertStatus(422);
    }
    public function test_task_deletion(): void
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'jd@jd.com',
            'username' => 'jd',
        ];
        $response = $this->delete('/api/task/1', $userData);
        $response->assertJsonStructure([
            '*' => [
                "id",
                "user_id",
                "category_id",
                "description",
                "created_at",
                "updated_at",
                "created_by",
                "updated_by",
                "deleted_by",
                "deleted_at",
            ]
        ]);
        $response->assertStatus(200);
    }
}
