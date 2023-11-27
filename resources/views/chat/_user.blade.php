@foreach ($getChatUser as $user)
<li class="clearfix getChatWindows"
 @if(!empty($receiver_id))
    @if($receiver_id==$user['user_id'])
      active
      @endif
      @endif
       id="{{ $user['user_id'] }}">
    <img src="{{ $user['profile_pic'] }}" alt="avatar" style="height:45px;">
    <div class="about">
        <div class="name">{{ $user['name'] }}
            @if(!empty($user['messagecount']))
         <span id="ClearMessage{{ $user['user_id'] }}" style="background: green;
            color: white;
            padding: 1px 8px;
            border-radius: 7px;">
            {{ $user['messagecount']}}
        </span>
            @endif
        </div>
        <div class="status"> <i class="fa fa-circle offline"></i> {{ Carbon\Carbon::parse($user['created_date'])->diffForHumans() }} </div>
    </div>
</li>
@endforeach

