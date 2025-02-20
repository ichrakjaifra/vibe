<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('User Avatar') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Add or Update Avatar.") }}
        </p>
    </header>

    @if (session('status') === 'Avatar updated')
    <div class="mb-4 font-medium text-sm text-green-600">
        {{ session('status') }}
    </div>
    @endif


    <form method="post" action="{{ route('profile.avatar') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch') 
    
    @if($user->avatar == "")
        <img class="rounded-full" src="{{ URL("/storage/avatars/user.png") }}" width="75" alt="avatar nout found!">
    @else
        <img class="rounded-full" src="{{ URL("/storage/$user->avatar") }}" width="75" alt="avatar nout found!">
    @endif    

        <div>
            <x-input-label for="avatar" value="Avatar" />
            <x-text-input id="avatar" name="avatar" type="file" class="mt-1 block w-full" :value="old('avatar', $user->avatar)" required  />
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'Avatar updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 4000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
