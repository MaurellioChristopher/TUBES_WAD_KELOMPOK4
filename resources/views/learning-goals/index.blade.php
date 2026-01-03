@extends('layouts.app')

@section('title', 'Users - Learning Goals')

@section('content')
<div id="main-container" class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">My Learning Goals</h1>
                <p class="text-gray-600 dark:text-gray-400">Track your learning progress and achieve your skill development goals</p>
            </div>
            
            <button onclick="toggleDarkMode()" class="p-3 rounded-full bg-white dark:bg-gray-800 shadow-md border border-gray-200 dark:border-gray-700 text-gray-800 dark:text-yellow-400 hover:scale-110 transition-all">
                <svg id="sun-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
                <svg id="moon-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
            </button>
        </div>

        @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
                <div class="flex">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-green-700 dark:text-green-300">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 p-8 transition-colors duration-300">

            <div class="flex justify-between items-center mb-8 pb-6 border-b border-gray-200 dark:border-gray-700">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Learning Goals</h2>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">{{ $goals->count() }} {{ $goals->count() == 1 ? 'goal' : 'goals' }} in progress</p>
                </div>
                <button onclick="openCreateGoalModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg flex items-center gap-2 transition-colors shadow-lg shadow-blue-500/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add New Goal
                </button>
            </div>

            @if($goals->count() > 0)
                <div class="space-y-4">
                    @foreach($goals as $goal)
                    <div class="border-2 border-gray-200 dark:border-gray-700 rounded-xl p-6 hover:border-blue-500 dark:hover:border-blue-400 hover:shadow-md transition-all bg-white dark:bg-gray-800">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $goal->title }}</h3>
                                
                                <div class="flex flex-wrap gap-3 text-sm text-gray-600 dark:text-gray-400">
                                    @if($goal->topic)
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                                            {{ $goal->topic->title }}
                                        </span>
                                    @endif
                                    @if($goal->skill)
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                                            {{ $goal->skill->name }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <span class="px-4 py-2 text-sm font-semibold rounded-full 
                                @if($goal->status == 'not_started') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                @elseif($goal->status == 'in_progress') bg-blue-50 text-blue-700 border-2 border-blue-200 dark:bg-blue-900/20 dark:text-blue-400 dark:border-blue-800
                                @else bg-green-50 text-green-700 border-2 border-green-200 dark:bg-green-900/20 dark:text-green-400 dark:border-green-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $goal->status)) }}
                            </span>
                        </div>

                        <div class="mb-4 bg-gray-50 dark:bg-gray-900/50 p-3 rounded-lg border border-gray-100 dark:border-gray-700">
                            <div class="flex justify-between mb-1">
                                <span class="text-xs font-bold text-gray-700 dark:text-gray-400 uppercase">Progress</span>
                                <span class="text-xs font-bold text-blue-700 dark:text-blue-400">{{ $goal->progress ?? 0 }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                <div class="bg-blue-600 dark:bg-blue-500 h-2.5 rounded-full transition-all duration-500" style="width: {{ $goal->progress ?? 0 }}%"></div>
                            </div>
                        </div>

                        <div class="flex gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <button onclick="editGoal({{ $goal->id }})" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 font-medium text-sm">Edit Goal</button>
                            <button onclick="deleteGoal({{ $goal->id }})" class="text-red-600 dark:text-red-400 hover:text-red-800 font-medium text-sm">Delete</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<div id="goalModal" class="hidden fixed inset-0 bg-gray-900/60 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-all">
    <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-1/2 shadow-2xl rounded-2xl bg-white dark:bg-gray-800 dark:border-gray-700 mb-10">
        <div class="mt-3">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6" id="modalTitle">Create Learning Goal</h3>
            <form id="goalForm" method="POST" action="{{ route('learning-goals.store') }}">
                @csrf
                <input type="hidden" id="goalMethod" name="_method" value="POST">
                <input type="hidden" name="progress" id="hiddenProgress" value="0">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Title *</label>
                        <input type="text" name="title" id="goalTitle" required class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg py-2.5 px-4 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Status *</label>
                        <select name="status" id="goalStatus" required onchange="handleStatusChange()" class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg py-2.5 px-4 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="not_started">Not Started</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>

                <div id="progressContainer" class="mt-6 mb-4 p-5 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800 hidden transition-all">
                    <label class="block text-blue-800 dark:text-blue-300 text-sm font-bold mb-3">
                        Completion Progress: <span id="progressLabel" class="text-blue-600 dark:text-blue-400 text-lg">0</span>%
                    </label>
                    <input type="range" id="goalProgressSlider" min="0" max="100" value="0" 
                           class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer accent-blue-600 dark:accent-blue-500"
                           oninput="updateProgress(this.value)">
                </div>

                <div class="flex justify-end space-x-4 mt-8">
                    <button type="button" onclick="closeGoalModal()" class="px-6 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-xl font-bold">Cancel</button>
                    <button type="submit" class="px-8 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-lg shadow-blue-500/30 transition-all">Save Goal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Logic Dark Mode
function toggleDarkMode() {
    const html = document.documentElement;
    const sunIcon = document.getElementById('sun-icon');
    const moonIcon = document.getElementById('moon-icon');

    if (html.classList.contains('dark')) {
        html.classList.remove('dark');
        localStorage.setItem('theme', 'light');
        sunIcon.classList.add('hidden');
        moonIcon.classList.remove('hidden');
    } else {
        html.classList.add('dark');
        localStorage.setItem('theme', 'dark');
        sunIcon.classList.remove('hidden');
        moonIcon.classList.add('hidden');
    }
}

// Cek tema saat halaman diload
(function initTheme() {
    const savedTheme = localStorage.getItem('theme');
    const sunIcon = document.getElementById('sun-icon');
    const moonIcon = document.getElementById('moon-icon');

    if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
        if(sunIcon) sunIcon.classList.remove('hidden');
        if(moonIcon) moonIcon.classList.add('hidden');
    }
})();

// Logic Progress & Modal (Sama seperti sebelumnya)
function updateProgress(val) {
    document.getElementById('progressLabel').textContent = val;
    document.getElementById('goalProgressSlider').value = val;
    document.getElementById('hiddenProgress').value = val;
}

function handleStatusChange() {
    const status = document.getElementById('goalStatus').value;
    const container = document.getElementById('progressContainer');
    if (status === 'in_progress') {
        container.classList.remove('hidden');
    } else {
        container.classList.add('hidden');
        updateProgress(status === 'completed' ? 100 : 0);
    }
}

function openCreateGoalModal() {
    document.getElementById('goalModal').classList.remove('hidden');
    document.getElementById('goalForm').reset();
    updateProgress(0);
}

function closeGoalModal() {
    document.getElementById('goalModal').classList.add('hidden');
}

function editGoal(id) {
    const goals = @json($goals);
    const goal = goals.find(g => g.id === id);
    if (!goal) return;

    document.getElementById('goalTitle').value = goal.title || '';
    document.getElementById('goalStatus').value = goal.status || 'not_started';
    updateProgress(goal.progress || 0);
    handleStatusChange();

    document.getElementById('goalForm').action = '/learning-goals/' + id;
    document.getElementById('goalMethod').value = 'PUT';
    document.getElementById('goalModal').classList.remove('hidden');
}
</script>
@endsection