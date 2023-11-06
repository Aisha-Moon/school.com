<x-mail::message>
    {{ $user->name }}




    <x-mail::button :url="url('reset/' . $user->remember_token)">
        Reset password link
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
