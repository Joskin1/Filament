<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="mb-4">
                    <h1 class="text-4xl font-bold">{{ $post->title }}</h1>
                </div>
                @if($post->image)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="rounded-lg w-full max-w-md mx-auto">
                </div>
                @endif
                <div class="mb-4">
                    <p class="text-gray-700">{{ $post->body }}</p>
                </div>
                <div class="text-gray-500 text-sm">
                    <p>Category: {{ $post->category->name }}</p>
                    {{-- <p>Author: {{ $post->author->name }}</p> --}}
                    <p>Published on: {{ $post->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
