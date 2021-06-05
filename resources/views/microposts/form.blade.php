{!! Form::open(['route' => 'microposts.store']) !!}
@csrf
    <div class="form-group">
        {!! Form::textarea('content',old('content'),['class' => 'form-control','rows' => '2','placeholder' => "content"]) !!}
            {!! Form::textarea('tag',old('tag'),['class' => 'form-control','rows' => '2','placeholder' => "tag(複数タグ付けする場合は半角スペースで区切ってください)"]) !!}
        {!! Form::submit('Post',['class' => 'btn btn-primary btn-block']) !!}
    </div>
{!! Form::close() !!}