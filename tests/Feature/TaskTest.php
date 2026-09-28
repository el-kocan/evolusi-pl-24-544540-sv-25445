<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_vue_can_read_tasks_from_json_api(): void
    {
        Task::create([
            'title' => 'Tugas dari API',
            'description' => 'Data untuk Vue',
        ]);

        $response = $this->getJson('/api/tugas');

        $response->assertOk()
            ->assertJsonPath('data.0.title', 'Tugas dari API')
            ->assertJsonPath('data.0.is_completed', false);
    }

    public function test_user_can_view_tasks_index_page(): void
    {
        $response = $this->get(route('tasks.index'));

        $response->assertStatus(200);
        $response->assertSee('Daftar Tugas Praktikum');
    }

    public function test_user_can_create_a_task(): void
    {
        $response = $this->post(route('tasks.store'), [
            'title' => 'Implementasi CI/CD Pipeline',
            'description' => 'Membuat 4 stage workflow di GitHub Actions',
        ]);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'title' => 'Implementasi CI/CD Pipeline',
            'description' => 'Membuat 4 stage workflow di GitHub Actions',
            'is_completed' => false,
        ]);
    }

    public function test_task_title_is_required(): void
    {
        $response = $this->post(route('tasks.store'), [
            'title' => '',
            'description' => 'Tanpa judul tugas',
        ]);

        $response->assertSessionHasErrors('title');
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_user_can_toggle_task_completion_status(): void
    {
        $task = Task::create([
            'title' => 'Tugas Pengujian Otomatis',
            'is_completed' => false,
        ]);

        $response = $this->patch(route('tasks.update', $task));

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'is_completed' => true,
        ]);
    }

    public function test_user_can_delete_a_task(): void
    {
        $task = Task::create([
            'title' => 'Tugas Yang Akan Dihapus',
        ]);

        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
}
