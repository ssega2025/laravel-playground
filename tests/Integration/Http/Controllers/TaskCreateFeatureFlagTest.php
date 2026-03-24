<?php

namespace Tests\Integration\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TaskCreateFeatureFlagTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function itHidesCreateButtonOnIndexWhenFeatureFlagIsDisabled(): void
    {
        Config::set('feature_flags.task_create_button', false);

        $response = $this->get(route('tasks.index'));

        $response->assertStatus(200);
        $response->assertDontSee('dusk="index-create-link"', false);
    }

    #[Test]
    public function itReturns404WhenCreatePageIsAccessedAndFeatureFlagIsDisabled(): void
    {
        Config::set('feature_flags.task_create_button', false);

        $response = $this->get(route('tasks.create'));

        $response->assertStatus(404);
    }

    #[Test]
    public function itReturns404WhenStoreIsCalledAndFeatureFlagIsDisabled(): void
    {
        Config::set('feature_flags.task_create_button', false);

        $response = $this->post(route('tasks.store'), [
            'title' => 'flag off task',
        ]);

        $response->assertStatus(404);
        $this->assertDatabaseMissing('tasks', [
            'title' => 'flag off task',
        ]);
    }
}
