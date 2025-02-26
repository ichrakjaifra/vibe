<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier le post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contenu</label>
                        <textarea id="content" name="content" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">{{ $post->content }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Image (optionnelle)</label>
                        <input type="file" id="image" name="image" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-black rounded-lg hover:bg-indigo-700 transition duration-200">
                            Modifier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>