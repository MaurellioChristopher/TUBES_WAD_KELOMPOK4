<?php

namespace App\Http\Controllers;

use App\Models\LearningGoal;
use App\Models\Skill;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LearningGoalController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $goals = $user->learningGoals()
            ->with(['skill', 'topic'])
            ->latest()
            ->get();

        $skills = Skill::orderBy('name')->get();
        $topics = Topic::orderBy('title')->get();

        return view('learning-goals.index', compact('goals', 'skills', 'topics'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'skill_id'    => 'nullable|exists:skills,id',
            'topic_id'    => 'nullable|exists:topics,id',
            'target_date' => 'nullable|date',
            'status'      => 'required|in:not_started,in_progress,completed',
            'notes'       => 'nullable|string',
        ]);

        $validated['progress'] = $this->calculateProgress($validated['status']);

        Auth::user()->learningGoals()->create($validated);

        return back()->with('success', 'Learning goal created successfully!');
    }

    public function update(Request $request, LearningGoal $learningGoal)
    {
        $this->authorizeGoal($learningGoal);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'skill_id'    => 'nullable|exists:skills,id',
            'topic_id'    => 'nullable|exists:topics,id',
            'target_date' => 'nullable|date',
            'status'      => 'required|in:not_started,in_progress,completed',
            'notes'       => 'nullable|string',
        ]);

        $validated['progress'] = $this->calculateProgress(
            $validated['status'],
            $learningGoal->progress
        );

        $learningGoal->update($validated);

        return back()->with('success', 'Learning goal updated successfully!');
    }

    public function destroy(LearningGoal $learningGoal)
    {
        $this->authorizeGoal($learningGoal);

        $learningGoal->delete();

        return back()->with('success', 'Learning goal deleted successfully!');
    }

    private function authorizeGoal(LearningGoal $learningGoal): void
    {
        if ($learningGoal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }

    private function calculateProgress(string $status, int $currentProgress = 0): int
    {
        return match ($status) {
            'completed'   => 100,
            'in_progress' => $currentProgress > 0 ? $currentProgress : 50,
            default       => 0,
        };
    }
}
