    @if(Auth::user()->is_favorite($micropost->id))
        {{-- お気に入り解除ボタンフォーム --}}
        {!! Form::open(['route' => ['micropost.unfavorite', $micropost->id], 'method' => 'delete']) !!}
            {!! Form::submit('Unfavorite', ['class' => "btn btn-danger btn-sm"]) !!}
        {!! Form::close() !!}
    @else
        {{-- お気に入り登録ボタンフォーム --}}
        {!! Form::open(['route' => ['micropost.favorite', $micropost->id]]) !!}
            {!! Form::submit('Favorite', ['class' => "btn btn-primary btn-sm"]) !!}
        {!! Form::close() !!}
    @endif