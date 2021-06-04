@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-8">
            <h3>タグ:{{ $tag->tag }} micropost一覧</h3>
        </div>
    </div>
    @include('microposts.microposts')
@endsection        