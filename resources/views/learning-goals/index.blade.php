@extends('layouts.app')

@section('title', 'My Learning Goals')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Learning Goals</h1>
            <p class="text-gray-600 mt-1">Track your progress and build your skills consistently</p>
        </div>

        <button onclick="openCreateGoalModal()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold flex items-center gap-2 shadow">
            ➕ Add Goal
        </button>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    {{-- Goals List --}}
    @if($goals->count() > 0)
        <div class="grid md:grid-cols-2 gap-6">
            @foreach($goals as $goal)
                <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-xl transition group">

                    {{-- Header --}}
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition">
                                {{ $goal->title }}
                            </h3>

                            <div class="flex flex-wrap gap-4 mt-2 text-sm text-gray-500">
                                @if($goal->topic)
                                    <span>📁 {{ $goal->topic->title }}</span>
                                @endif
                                @if($goal->skill)
                                    <span>🛠 {{ $goal->skill->name }}</span>
                                @endif
                                @if($goal->target_date)
                                    <span>📅 {{ $goal->target_date->format('d M Y') }}</span>
                                @endif
                            </div>
                        </div>

                        {{-- Status --}}
                        <span class="px-4 py-1.5 text-xs font-semibold rounded-full
                            @if($goal->status == 'not_started') bg-gray-100 text-gray-700
                            @elseif($goal->status == 'in_progress') bg-blue-100 text-blue-700
                            @else bg-green-100 text-green-700 @endif">
                            {{ strtoupper(str_replace('_',' ', $goal->status)) }}
                        </span>
                    </div>

                    {{-- Description --}}
                    @if($goal->description)
                        <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                            {{ Str::limit($goal->description, 120) }}
                        </p>
                    @endif

                    {{-- Progress --}}
                    <div class="mb-4">
                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                            <span>Progress</span>
                            <span>
                                @if($goal->status == 'completed') 100%
                                @elseif($goal->status == 'in_progress') 60%
                                @else 0% @endif
                            </span>
                        </div>

                        <div class="w-full bg-gray-200 h-2 rounded-full">
                            <div class="h-2 rounded-full
                                @if($goal->status == 'completed') bg-green-500 w-full
                                @elseif($goal->status == 'in_progress') bg-blue-500 w-3/5
                                @else bg-gray-400 w-1/12 @endif">
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex justify-end gap-4 pt-3 border-t border-gray-100">
                        <button onclick="editGoal({{ $goal->id }})"
                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            ✏ Edit
                        </button>
                        <button onclick="deleteGoal({{ $goal->id }})"
                            class="text-red-600 hover:text-red-800 text-sm font-medium">
                            🗑 Delete
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        {{-- Empty State --}}
        <div class="text-center py-20 bg-white rounded-2xl border border-dashed">
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Learning Goals</h3>
            <p class="text-gray-600 mb-6">Create your first goal to start learning 🚀</p>
            <button onclick="openCreateGoalModal()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold">
                Create Goal
            </button>
        </div>
    @endif
</div>

{{-- MODAL --}}
<div id="goalModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-2xl max-w-xl mx-auto mt-24 p-6 shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h3 id="modalTitle" class="text-lg font-bold">Create Goal</h3>
            <button onclick="closeGoalModal()" class="text-gray-500">✖</button>
        </div>

        <form id="goalForm" method="POST" action="{{ route('learning-goals.store') }}">
            @csrf
            <input type="hidden" id="goalMethod" name="_method" value="POST">

            <div class="space-y-4">
                <input type="text" name="title" id="goalTitle" placeholder="Goal title"
                    class="w-full border rounded-lg px-4 py-2" required>

                <select name="topic_id" id="goalTopic" class="w-full border rounded-lg px-4 py-2">
                    <option value="">Select Topic</option>
                    @foreach($topics as $topic)
                        <option value="{{ $topic->id }}">{{ $topic->title }}</option>
                    @endforeach
                </select>

                <select name="skill_id" id="goalSkill" class="w-full border rounded-lg px-4 py-2">
                    <option value="">Select Skill</option>
                    @foreach($skills as $skill)
                        <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                    @endforeach
                </select>

                <input type="date" name="target_date" id="goalDate"
                    class="w-full border rounded-lg px-4 py-2">

                <select name="status" id="goalStatus" class="w-full border rounded-lg px-4 py-2">
                    <option value="not_started">Not Started</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>

                <textarea name="description" id="goalDescription" rows="3"
                    class="w-full border rounded-lg px-4 py-2"
                    placeholder="Description"></textarea>

                <textarea name="notes" id="goalNotes" rows="2"
                    class="w-full border rounded-lg px-4 py-2"
                    placeholder="Notes"></textarea>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeGoalModal()"
                    class="px-4 py-2 bg-gray-200 rounded-lg">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openCreateGoalModal() {
    document.getElementById('goalModal').classList.remove('hidden');
    document.getElementById('goalForm').reset();
    document.getElementById('goalMethod').value = 'POST';
    document.getElementById('goalForm').action = '{{ route('learning-goals.store') }}';
    document.getElementById('modalTitle').innerText = 'Create Goal';
}

function closeGoalModal() {
    document.getElementById('goalModal').classList.add('hidden');
}

function editGoal(id) {
    const goals = @json($goals);
    const goal = goals.find(g => g.id === id);
    if (!goal) return;

    goalTitle.value = goal.title ?? '';
    goalTopic.value = goal.topic_id ?? '';
    goalSkill.value = goal.skill_id ?? '';
    goalStatus.value = goal.status ?? 'not_started';
    goalDescription.value = goal.description ?? '';
    goalNotes.value = goal.notes ?? '';
    goalDate.value = goal.target_date ?? '';

    goalMethod.value = 'PUT';
    goalForm.action = '/learning-goals/' + id;
    modalTitle.innerText = 'Edit Goal';
    openCreateGoalModal();
}

function deleteGoal(id) {
    if (!confirm('Delete this goal?')) return;
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/learning-goals/' + id;
    form.innerHTML = '@csrf @method("DELETE")';
    document.body.appendChild(form);
    form.submit();
}
</script>
@endsection
