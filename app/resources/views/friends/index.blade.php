<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Amis et Demandes d\'amis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Section des amis -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Mes amis</h3>
                    @if($friends->isEmpty())
                        <p>Aucun ami pour le moment.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-4 gap-6">
                            @foreach($friends as $friend)
                                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition duration-300 ease-in-out">
                                    <div class="p-6">
                                        <div class="flex items-center space-x-4">
                                            @if($friend->avatar)
                                                <img src="{{ asset('storage/' . $friend->avatar) }}" 
                                                     alt="Avatar de {{ $friend->pseudo }}" 
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
                                                    {{ $friend->pseudo }}
                                                </h3>
                                                <p class="text-indigo-600 dark:text-indigo-400">
                                                    {{ $friend->email }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                            <p class="text-gray-600 dark:text-gray-300 line-clamp-3">
                                                {{ $friend->bio ?: 'Aucune biographie disponible.' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Section des demandes d'amis -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Demandes d'amis</h3>
                    @if($friendRequests->isEmpty())
                        <p>Aucune demande d'ami pour le moment.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 p-4 gap-6">
                            @foreach($friendRequests as $request)
                                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition duration-300 ease-in-out">
                                    <div class="p-6">
                                        <div class="flex items-center space-x-4">
                                            @if($request->avatar)
                                                <img src="{{ asset('storage/' . $request->avatar) }}" 
                                                     alt="Avatar de {{ $request->pseudo }}" 
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
                                                    {{ $request->pseudo }}
                                                </h3>
                                                <p class="text-indigo-600 dark:text-indigo-400">
                                                    {{ $request->email }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                            <p class="text-gray-600 dark:text-gray-300 line-clamp-3">
                                                {{ $request->bio ?: 'Aucune biographie disponible.' }}
                                            </p>
                                        </div>
                                        <div class="mt-6 flex justify-end space-x-4">
                                            <form action="{{ route('friends.update', $request->pivot->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="accepted">
                                                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-200">
                                                    Accepter
                                                </button>
                                            </form>
                                            <form action="{{ route('friends.update', $request->pivot->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-200">
                                                    Refuser
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>