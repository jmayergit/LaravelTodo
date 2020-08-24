<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

define('AJAX_HEADERS', [
    'X-Requested-With' => 'XMLHttpRequest',
    'Accept' => 'application/json, text/plain, */*',
]);

class TodosControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStoreSuccess()
    {
        $params = ['description' => 'a description', 'user_id' => 1];
        $response = $this->withHeaders(AJAX_HEADERS)->post('/api/todos', $params);


        $response->assertStatus(201);
    }

    public function testStoreFailure()
    {
        $params = ['description' => 'a description that is too long and will fail validation', 'user_id' => 1];
        $response = $this->withHeaders(AJAX_HEADERS)->post('/api/todos', $params);

        $response->assertStatus(422);
    }

    public function testUpdate()
    {
        $todo = factory(\App\Todo::class)->create();
        $uri = "/api/todos/$todo->id";
        $params = ['description' => 'SSR'];
        $response = $this->withHeaders(AJAX_HEADERS)->put($uri, $params);

        $response->assertStatus(200)
                 ->assertJson(['description' => 'SSR']);
    }

    public function testUpdateMultiple()
    {
        $users = Factory(\App\User::class, 1)
                    ->create()
                    ->each(function ($user) {
                        $user->todos()->createMany(factory(\App\Todo::class, 3)->make([
                            'user_id' => $user->id, // override
                        ])->toArray());
                    });
        $ids = $users[0]
                    ->todos
                    ->map(function ($todo) {
                        return $todo->id;
                    });
        $params = ['ids' => $ids, 'completed' => 1];
        $response = $this->withHeaders(AJAX_HEADERS)->put('/api/todos/multiple', $params);

        $response->assertStatus(200);
    }

    public function testDestroy() 
    {
        $todo = factory(\App\Todo::class)->create();

        $response = $this->withHeaders(AJAX_HEADERS)->delete("/api/todos/$todo->id");
        
        $response->assertStatus(200);

        $this->assertDeleted($todo); // assertSoftDeleted
    }

    public function testDestroyMultiple()
    {
        $todos = factory(\App\Todo::class, 3)->create();

        $ids = $todos->map(function ($todo) {
            return $todo->id;
        });
        $params = ['ids' => $ids];

        $response = $this->withHeaders(AJAX_HEADERS)->delete('/api/todos/multiple', $params);

        $response->assertStatus(200);

        $this->assertDeleted($todos[0]); // efficient way to assert 3 records deleted ?
    }
}
