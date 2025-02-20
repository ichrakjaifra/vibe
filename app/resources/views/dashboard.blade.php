<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Formulaire de recherche -->
            <form action="{{ route('dashboard') }}" method="GET" class="mb-6">
                <div class="flex">
                    <input type="text" name="search" placeholder="Rechercher par pseudo ou email" class="w-full px-4 py-2 border rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-r-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Rechercher
                    </button>
                </div>
            </form>

            <!-- Tableau des utilisateurs -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Liste des utilisateurs</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 dark:border-gray-600 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Avatar</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 dark:border-gray-600 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Pseudo</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 dark:border-gray-600 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Email</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 dark:border-gray-600 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Bio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <td class="px-6 py-4 border-b border-gray-300 dark:border-gray-600">
                                            @if($user->avatar)
                                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-10 h-10 rounded-full">
                                            @else
                                                <img src="{{ asset('storage/avatars/user.png') }}" alt="Avatar" class="w-10 h-10 rounded-full">
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 border-b border-gray-300 dark:border-gray-600">{{ $user->pseudo }}</td>
                                        <td class="px-6 py-4 border-b border-gray-300 dark:border-gray-600">{{ $user->email }}</td>
                                        <td class="px-6 py-4 border-b border-gray-300 dark:border-gray-600">{{ $user->bio }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
