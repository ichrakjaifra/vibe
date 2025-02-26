<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Amis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Liste des amis -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($friends as $friend)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('storage/' . $friend->avatar) }}" alt="Avatar" class="w-10 h-10 rounded-full">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $friend->pseudo }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $friend->email }}</p>
                            </div>
                        </div>

                        <!-- Bouton Accepter/Refuser (si la demande est en attente) -->
                        @if ($friend->pivot->status == 'pending')
                        <div class="mt-4 flex space-x-4">
                            <form action="{{ route('friends.update', $friend->pivot->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="accepted">
                                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-200">
                                    Accepter
                                </button>
                            </form>
                            <form action="{{ route('friends.update', $friend->pivot->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-200">
                                    Refuser
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>