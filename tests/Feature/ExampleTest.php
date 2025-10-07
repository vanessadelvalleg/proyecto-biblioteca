<?php
namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /** @test */
    public function returns_a_successful_response()
    {
        $response = $this->get('/');
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }
}