@if(Auth::id() != $user->id)
    @if(Auth::user()->is_following($user->id))
        {{-- アンフォローボタンフォーム --}}
        {!! Form::open(['route' => ['user.unfollow',$user->id],'method' => 'delete']) !!}
            {!! Form::submit('Unfollow',['class' => "btn btn-primary btn-block"]) !!}
        {!! Form::close() !!}
    @else
        {{-- フォローボタンフォーム --}}
        {!! Form::open(['route' => ['user.follow',$user->id]]) !!}
            {!! Form::submit('Follow',['class' => "btn btn-primary btn-block"]) !!}
        {!! Form::close() !!}
    @endif
@endif