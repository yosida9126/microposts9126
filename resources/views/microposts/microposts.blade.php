@if(count($microposts) > 0)
    <ul class="list-unstyled">
        @foreach($microposts as $micropost)
            <li class="media mb-3">
                {{-- 投稿の所有者のメールアドレスを元にGravatarを取得、表示 --}}
                <img class="mr-2 rounded" src="{{ Gravatar::get($micropost->user->email,['size' => 50]) }}" alt="">
                <div class="media-body">
                    <div>
                        {{-- 投稿の所有者のユーザ詳細ページへのリンク --}}
                        {!! link_to_route('users.show',$micropost->user->name,['user' => $micropost->user->id]) !!}
                        <span class="text-muted">posted at {{ $micropost->created_at }}</span>
                    </div>
                    <div>
                        {{--タグ一覧--}}
                        <ul class="list-unstyled">
                            <?php $tags = $micropost->tags()->get() ?>
                            <li>tag: 
                                @foreach($tags as $tag)
                                    {!! link_to_route('tags.show',$tag->tag,['tag' => $tag->id]) !!}
                                @endforeach
                            </li>
                        </ul>
                    </div>
                    <div>
                        {{-- 投稿内容 --}}
                        <p class="mb-0">content: {!! nl2br(e($micropost->content)) !!}</p>
                    </div>
                    <div class="d-flex flex-row">
                        <div class="p-2">
                            @include('favorites.favorite_button')
                        </div>
                        <div class="p-2">
                            @if(Auth::id() == $micropost->user_id)
                                {!! link_to_route('microposts.edit','edit',['micropost' => $micropost->id],['class' => 'btn btn-primary btn-sm']) !!}
                            @endif
                        </div>
                        <div class="p-2">
                            @if(Auth::id() == $micropost->user_id)
                            {{-- 投稿削除ボタンフォーム --}}
                            {!! Form::open(['route' => ['microposts.destroy',$micropost->id],'method' => 'delete']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                            @endif
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    {{-- ページネーションのリンク --}}
    {{ $microposts->links() }}
@endif