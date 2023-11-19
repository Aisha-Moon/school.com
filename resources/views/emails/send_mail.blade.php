<x-mail::message>
    Hello {{ $user->name }}

{!! $user->send_message !!}


    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
