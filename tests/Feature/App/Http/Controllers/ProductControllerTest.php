<?php
declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testBasic()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
