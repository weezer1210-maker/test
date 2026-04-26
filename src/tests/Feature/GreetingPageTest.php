<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GreetingPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_greeting_page_returns_ok(): void
    {
        $response = $this->get('/greeting');

        $response->assertStatus(200);
    }

    public function test_greeting_page_contains_form(): void
    {
        $response = $this->get('/greeting');

        $response->assertSee('name="name"', false);
        $response->assertSee('name="message"', false);
        $response->assertSee('type="submit"', false);
    }

    public function test_greeting_page_shows_empty_state_when_no_greetings(): void
    {
        $response = $this->get('/greeting');

        $response->assertSee('まだあいさつがありません');
    }
}
