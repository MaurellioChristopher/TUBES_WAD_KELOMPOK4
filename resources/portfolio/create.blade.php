@extends('layouts.app')

@section('title', 'Add New Portfolio Item')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Add New Portfolio Item</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <strong class="font-bold">Oops!</strong>
                <span class="block sm:inline">Ada beberapa masalah dengan input Anda.</span>
                <ul class="mt-3 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('portfolio.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                <input type="text" name="title" id="title" 
                       value="{{ old('title') }}" 
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror" 
                       required>
                @error('title')<p class="text-red-500 text-xs italic">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <textarea name="description" id="description" rows="5" maxlength="500"
                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror" 
                          required>{{ old('description') }}</textarea>
                          <p class="text-xs text-gray-500 mt-1">Maximum 500 characters</p>
                @error('description')<p class="text-red-500 text-xs italic">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label for="link" class="block text-gray-700 text-sm font-bold mb-2">Link (optional)</label>
                <input type="url" name="link" id="link" 
                       value="{{ old('link') }}" 
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('link') border-red-500 @enderror">
                @error('link')<p class="text-red-500 text-xs italic">{{ $message }}</p>@enderror
            </div>


            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Skills</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                    @forelse($skills as $skill)
                        <div>
                            <input type="checkbox" name="skills[]" id="skill_{{ $skill->id }}" value="{{ $skill->id }}" 
                                   {{ in_array($skill->id, old('skills', [])) ? 'checked' : '' }}
                                   class="mr-2 leading-tight">
                            <label for="skill_{{ $skill->id }}" class="text-sm text-gray-700">{{ $skill->name }}</label>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 col-span-full">No skills available. Please add some skills first.</p>
                    @endforelse
                </div>
                @error('skills')<p class="text-red-500 text-xs italic">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label for="file" class="block text-gray-700 text-sm font-bold mb-2">File (optional)</label>
                <input type="file" name="file" id="file" 
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('file') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">Accepts PDF, DOC, DOCX, JPG, JPEG, PNG (Max 2MB)</p>
                <p class="text-xs text-yellow-600 mt-1"> Catatan: Kalau validasi gagal, filenya harus dipilih ulang ya. </p>
                @error('file')<p class="text-red-500 text-xs italic">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('dashboard') }}" class="inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800 mr-4">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 active:scale-95 transition transform duration-200 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Save Portfolio
                </button>
            </div>
        </form>
    </div>
        <p class="text-xs text-yellow-600 mt-1">
            Catatan: Kalau validasi gagal, filenya harus dipilih ulang ya.
        </p>
</div>
@endsection