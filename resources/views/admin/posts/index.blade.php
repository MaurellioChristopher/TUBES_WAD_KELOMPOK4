@extends('layouts.app')

@section('title', 'Admin - Post Management')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Headernya -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-newspaper text-green-600 mr-2"></i>
            Post Management
        </h1>
        <p class="text-gray-600 mt-2">Manage all posts created by users</p>
    </div>

    <!-- Success atau error -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Statistics Summary nya -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Posts</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $posts->total() }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <i class="fas fa-newspaper text-blue-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Open for Help</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $posts->where('type', 'open')->count() }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-hand-holding-heart text-green-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Need Help</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $posts->where('type', 'need')->count() }}</p>
                </div>
                <div class="bg-orange-100 rounded-full p-3">
                    <i class="fas fa-question-circle text-orange-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Posts Cards nya -->
<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
    @forelse($posts as $post)
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <!-- Header nya -->
            <div class="flex justify-between items-start mb-4">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $post->title }}</h3>
                    <p class="text-sm text-gray-600">
                        <i class="fas fa-user mr-1"></i>
                        {{ optional($post->user)->name ?? 'Unknown' }}
                    </p>
                    @if($post->user)
                        <p class="text-xs text-gray-500">
                            {{ $post->user->department ?? 'N/A' }} • {{ $post->user->batch ?? 'N/A' }}
                        </p>
                    @endif
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $post->type == 'open' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                    {{ $post->type == 'open' ? 'Open for Help' : 'Need Help' }}
                </span>
            </div>
            
            <!-- Description nya -->
            <p class="text-gray-700 mb-4 text-sm">{{ Str::limit($post->description, 120) }}</p>
            
            <!-- Page Topic nya -->
            @if($post->topic)
                <div class="mb-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                        <i class="fas fa-folder mr-1"></i>{{ $post->topic->title }}
                    </span>
                </div>
            @endif
            
            <!-- Skills nya -->
            @if($post->skills && $post->skills->count() > 0)
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach($post->skills->take(3) as $skill)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-code mr-1 text-xs"></i>{{ $skill->name }}
                        </span>
                    @endforeach

                    @php $skillCount = $post->skills->count(); @endphp
                    @if($skillCount > 3)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                            +{{ $skillCount - 3 }} more
                        </span>
                    @endif
                </div>
            @endif

            <!-- Footer nya ini -->
            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                <div class="flex items-center text-sm text-gray-500">
                    <i class="far fa-calendar mr-1"></i>
                    {{ $post->created_at->diffForHumans() }}
                </div>
                
                <button onclick="confirmDelete({{ $post->id }})"
                        class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md transition">
                    <i class="fas fa-trash mr-1"></i>
                    Delete
                </button>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-12 bg-white rounded-lg shadow-md">
            <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No posts</h3>
            <p class="text-gray-600">No posts created by users yet</p>
        </div>
    @endforelse
</div>

{{-- Pagination hanya ditampilkan jika jumlah data melebihi satu halaman --}}
@if($posts->hasPages())
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
@endif
