@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-8">
            <h3>Micropost編集ページ</h3>
                <li class="media mb-3">
                    {{-- 投稿の所有者のメールアドレスを元にGravatarを取得、表示 --}}
                    <img class="mr-2 rounded" src="{{ Gravatar::get($micropost->user->email,['size' => 50]) }}" alt="">
                    <div class="media-body">
                        <div>
                            {{-- 投稿の所有者のユーザ詳細ページへのリンク --}}
                            {!! link_to_route('users.show',$micropost->user->name,['user' => $micropost->user->id]) !!}
                            <span class="text-muted">posted at {{ $micropost->created_at }}</span>
                        </div>
                        <div class="col-10">
                            {!! Form::model($micropost,['route' => ['microposts.update',$micropost->id], 'method' => 'put']) !!}
                                <div class="form-group">
                                    {!! Form::label('content','content:') !!}
                                    {!! Form::text('content',null,['class' => 'form-control']) !!}
                                    {!! Form::label('tag','tag(複数タグ付けする場合は半角スペースで区切ってください):') !!}
                                    {!! Form::text('tag',$tags,['class' => 'form-control']) !!}
                                </div>
                                {!! Form::submit('Update',['class' => 'btn btn-primary btn-sm']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </li>
        </div>
    </div>
@endsection