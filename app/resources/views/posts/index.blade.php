<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Bouton pour créer un post -->
            <div class="mb-8">
                <a href="{{ route('posts.create') }}" class="px-4 py-2 bg-indigo-600 text-black rounded-lg hover:bg-indigo-700 transition duration-200">
                    Créer un post
                </a>
            </div>

            <!-- Liste des posts -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($posts as $post)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                    <div class="p-6">
                        <!-- Auteur du post -->
                        <div class="flex items-center space-x-4 mb-4">
                            <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="Avatar" class="w-7 h-7 rounded-full">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $post->user->pseudo }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        <!-- Contenu du post -->
                        <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $post->content }}</p>

                        <!-- Image du post (si elle existe) -->
                        @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" class="w-full rounded-lg mb-4">
                        @endif

                        <!-- Boutons d'actions -->
                        <div class="flex items-center justify-between">
                            <!-- Bouton Like -->
                            <form action="{{ route('likes.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <button type="submit" class="flex items-center text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    {{ $post->likes_count }}
                                </button>
                            </form>

                            <!-- Bouton Supprimer (uniquement pour l'auteur du post) -->
                            @if ($post->user_id == auth()->id())
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    Supprimer
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>