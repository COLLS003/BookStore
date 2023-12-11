<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_store_an_author_with_books()
    {
        $response = $this->json('POST', '/api/authors/create', [
            'firstname' => 'charles',
            'lastname' => 'juma'
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'firstname',
                    'lastname',
                    'created_at',
                    'updated_at',
                    'books' => [
                        '*' => [
                            'id',
                            'isbn',
                            'name',
                            'year',
                            'page',
                            'created_at',
                            'updated_at',
                            'pivot' => [
                                'author_id',
                                'book_id',
                            ],
                        ],
                    ],
                ],
            ]]);
    }
}
