<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Nwidart\Modules\Facades\Module;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_loads_with_smart_widgets()
    {
        $user = User::factory()->create();
        
        // Mock modules enabled
        // Note: Nwidart modules usually persist in config/cache, might be hard to mock in feature test without extensive setup.
        // Assuming environment has them enabled or logic handles it.
        
        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(200);
        $response->assertViewHas('smartWidgets');
        $response->assertViewHas('stats');
    }
}
