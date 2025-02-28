<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-indigo-900 dark:text-indigo-200 leading-tight">
            {{ __('Découvrir les utilisateurs') }}
        </h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        </div>
    </div>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 space-x-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('dashboard') }}" method="GET" class="mb-8">
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           placeholder="Rechercher un utilisateur par pseudo ou email..." 
                           class="w-full px-6 py-4 bg-white dark:bg-gray-800 rounded-full shadow-sm border-0 focus:ring-2 focus:ring-indigo-500 text-gray-900 dark:text-gray-100"
                    >
                    <button type="submit" 
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full transition duration-200 ease-in-out"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-4 gap-6">
                @foreach ($users as $user)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition duration-300 ease-in-out">
                    <div class="p-6">
                        <div class="flex items-center space-x-4">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" 
                                     alt="Avatar de {{ $user->pseudo }}" 
                                     class="w-16 h-16 rounded-full object-cover border-4 border-indigo-100 dark:border-indigo-900"
                                >
                            @else
                                <img src="{{ asset('storage/avatars/user.png') }}" 
                                     alt="Avatar par défaut" 
                                     class="w-16 h-16 rounded-full object-cover border-4 border-indigo-100 dark:border-indigo-900"
                                >
                            @endif
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                                    {{ $user->pseudo }}
                                </h3>
                                <p class="text-indigo-600 dark:text-indigo-400">
                                    {{ $user->email }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <p class="text-gray-600 dark:text-gray-300 line-clamp-3">
                                {{ $user->bio ?: 'Aucune biographie disponible.' }}
                            </p>
                        </div>
                        
                        <div class="mt-6 flex justify-between">
    <a href="{{ route('profile.show', $user->id) }}" 
       class="inline-flex items-center px-4 py-2 bg-indigo-50 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-200 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-800 transition duration-200">
        Voir le profil
    </a>

    @if ($acceptedFriends->contains($user->id))
        <form action="{{ route('friends.destroy', $user->id) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-200">
                Unfollow ami
            </button>
        </form>
    @elseif ($sentRequests->contains($user->id))
        <button class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg" disabled>
            Demande envoyée
        </button>
    @elseif ($receivedRequests->contains($user->id))
    @php
        // Récupérer l'objet Friend correspondant à la demande d'ami
        $friendRequest = Auth::user()->friendRequests()->where('user_id', $user->id)->first();
    @endphp

    <form action="{{ route('friends.update', $friendRequest->pivot->id) }}" method="POST" class="inline">
        @csrf
        @method('PATCH')
        <input type="hidden" name="status" value="accepted">
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-200">
            Accepter
        </button>
    </form>
    <form action="{{ route('friends.update', $friendRequest->pivot->id) }}" method="POST" class="inline">
        @csrf
        @method('PATCH')
        <input type="hidden" name="status" value="rejected">
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-200">
            Refuser
        </button>
    </form>
    @else
        <form action="{{ route('friends.store', $user->id) }}" method="POST">
            @csrf
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-50 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-200 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-800 transition duration-200">
                Ajouter ami
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
