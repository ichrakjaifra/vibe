<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-indigo-900 dark:text-indigo-200 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Bouton pour créer un post -->
            <div class="mb-8">
                <a href="{{ route('posts.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-200">
                    Créer un post
                </a>
            </div>

            <!-- Liste des posts -->
            <div class="flex flex-col gap-6">
                @foreach ($posts as $post)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                        <div class="p-6">
                            <!-- Auteur du post -->
                            <div class="flex items-center space-x-4 mb-4">
                                <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="Avatar" class="w-8 h-8 rounded-full">
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
                                <form action="{{ route('likes.toggle') }}" method="POST" class="like-form" data-post-id="{{ $post->id }}">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <button type="submit" class="flex items-center text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400">
                                        <svg class="w-5 h-5 mr-2 {{ $post->likes->contains('user_id', auth()->id()) ? 'text-red-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                        <span class="likes-count">{{ $post->likes->count() }}</span>
                                    </button>
                                </form>

                                <!-- Boutons Modifier et Supprimer (uniquement pour l'auteur du post) -->
                                @if ($post->user_id == auth()->id())
                                    <div class="flex items-center space-x-4">
                                        <a href="{{ route('posts.edit', $post->id) }}" class="text-indigo-600 hover:text-indigo-800">
                                            Modifier
                                        </a>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>

                            <!-- Formulaire de commentaire -->
                            <form action="{{ route('comments.store') }}" method="POST" class="mt-4">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <div class="flex items-center">
                                    <textarea name="content" rows="1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" placeholder="Ajouter un commentaire..."></textarea>
                                    <button type="submit" class="ml-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-200">
                                        Envoyer
                                    </button>
                                </div>
                            </form>

                            <!-- Liste des commentaires -->
                            <div class="mt-4">
                                @foreach ($post->comments as $comment)
                                    <div class="flex items-center space-x-4 mb-4">
                                        <img src="{{ asset('storage/' . $comment->user->avatar) }}" alt="Avatar" class="w-7 h-7 rounded-full">
                                        <div>
                                            <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $comment->user->pseudo }}</h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $comment->content }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Script JavaScript pour gérer les likes -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const likeForms = document.querySelectorAll('.like-form');

            likeForms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const postId = form.getAttribute('data-post-id');
                    const likeButton = form.querySelector('button');
                    const likesCount = form.querySelector('.likes-count');

                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            post_id: postId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Mettre à jour le nombre de likes
                            likesCount.textContent = data.likes_count;

                            // Changer la couleur du bouton like
                            const svg = likeButton.querySelector('svg');
                            if (data.message === 'Post liké.') {
                                svg.classList.add('text-red-500');
                            } else {
                                svg.classList.remove('text-red-500');
                            }
                        }
                    })
                    .catch(error => console.error('Erreur:', error));
                });
            });
        });
    </script>
</x-app-layout>