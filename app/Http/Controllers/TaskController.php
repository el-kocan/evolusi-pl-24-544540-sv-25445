<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks.
     */
    public function index(): View
    {
        $tasks = Task::latest()->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Store a newly created task.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil ditambahkan.');
    }

    /**
     * Toggle the status of the specified task.
     */
    public function update(Task $task): RedirectResponse
    {
        $task->update([
            'is_completed' => ! $task->is_completed,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Status tugas berhasil diperbarui.');
    }

    /**
     * Remove the specified task.
     */
    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus.');
    }
}
