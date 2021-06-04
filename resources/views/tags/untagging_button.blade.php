{!! Form::open(['route' => ['micropost.untagging',$micropost->id], 'method' => 'delete']) !!}
    {!! Form::submit('Untagging', ['class' => 'btn btn-danger btn-sm']) !!}
{!! Form::close() !!}