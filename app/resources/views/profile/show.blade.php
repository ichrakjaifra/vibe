<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-indigo-900 dark:text-indigo-200 leading-tight">
            Profil de {{ $user->pseudo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <!-- Avatar et informations de l'utilisateur -->
                    <div class="flex items-center space-x-4 mb-6">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" 
                                 alt="Avatar de {{ $user->pseudo }}" 
                                 class="w-20 h-20 rounded-full object-cover border-4 border-indigo-100 dark:border-indigo-900"
                            >
                        @else
                            <img src="{{ asset('storage/avatars/user.png') }}" 
                                 alt="Avatar par défaut" 
                                 class="w-20 h-20 rounded-full object-cover border-4 border-indigo-100 dark:border-indigo-900"
                            >
                        @endif
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $user->pseudo }}
                            </h3>
                            <p class="text-indigo-600 dark:text-indigo-400">
                                {{ $user->email }}
                            </p>
                        </div>
                    </div>

                    <!-- Biographie de l'utilisateur -->
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                            Biographie
                        </h4>
                        <p class="text-gray-600 dark:text-gray-300">
                            {{ $user->bio ?: 'Aucune biographie disponible.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>