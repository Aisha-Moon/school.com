@foreach ($getChatUser as $user)
<li class="clearfix">
    <a href="{{ url('chat?receiver_id='.base64_encode($user['user_id'])) }}">
    <img src="{{ $user['profile_pic'] }}" alt="avatar" style="height:45px;">
    <div class="about">
        <div class="name">{{ $user['name'] }}
            @if(!empty($user['messagecount']))
         <span style="background: green;
            color: white;
            padding: 1px 8px;
            border-radius: 7px;">
            {{ $user['messagecount']}}
        </span>
            @endif
        </div>
        <div class="status"> <i class="fa fa-circle offline"></i> {{ Carbon\Carbon::parse($user['created_date'])->diffForHumans() }} </div>
    </div>
</a>
</li>
@endforeach

{{-- <li class="clearfix active">
    <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
    <div class="about">
        <div class="name">Aiden Chavez</div>
        <div class="status"> <i class="fa fa-circle online"></i> online </div>
    </div>
</li> --}}
