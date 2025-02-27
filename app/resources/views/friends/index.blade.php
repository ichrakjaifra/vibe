<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Amis et Demandes d\'amis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Mes amis</h3>
                    @if($friends->isEmpty())
                        <p>Aucun ami pour le moment.</p>
                    @else
                        <ul>
                            @foreach($friends as $friend)
                                <li>{{ $friend->pseudo }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <h3 class="text-lg font-semibold mt-8 mb-4">Demandes d'amis</h3>
                    @if($friendRequests->isEmpty())
                        <p>Aucune demande d'ami pour le moment.</p>
                    @else
                        <ul>
                        @foreach($friendRequests as $request)
    <li>
        {{ $request->pseudo }}
        <form action="{{ route('friends.update', $request->pivot->id) }}" method="POST" class="inline">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="accepted">
            <button type="submit" class="text-green-500">Accepter</button>
        </form>
        <form action="{{ route('friends.update', $request->pivot->id) }}" method="POST" class="inline">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="rejected">
            <button type="submit" class="text-red-500">Refuser</button>
        </form>
    </li>
@endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>