<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <h1 class="text-4xl font-bold text-center mb-8">Blog Posts</h1>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($posts as $post)
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            @if ($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image"
                                    class="mb-4 rounded-lg w-full">
                            @endif
                            <h2 class="text-2xl font-bold mb-2">{{ $post->title }}</h2>
                            <p class="text-gray-700">{{ Str::limit($post->body, 150) }}</p>
                            <p class="text-gray-500 text-sm">Categories:
                                <span>{{ $post->category->name }}</span>
                            </p>
                            <p>Published on: {{ $post->created_at->format('M d, Y') }}</p>
                            <a href="{{ route('posts.show', $post) }}"
                                class="text-indigo-500 hover:text-indigo-600 mt-4 block">Read More</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</x-app-layout>
