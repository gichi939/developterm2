@extends('layouts.front')

@section('content')
    <div class="container">
        <div class="row">
            <div class="posts col-md-8 mx-auto mt-3">
                @foreach($posts as $post)
                        @if($post->is_liked_by_auth_user())
                          <a href="{{ route('reply.unlike', ['id' => $post->id]) }}" class="btn btn-success btn-sm">いいね<span class="badge">{{ $post->likes->count() }}</span></a>
                        @else
                          <a href="{{ route('reply.like', ['id' => $post->id]) }}" class="btn btn-secondary btn-sm">いいね<span class="badge">{{ $post->likes->count() }}</span></a>
                        @endif
                    <div class="post">
                        <div class="row">
                            <div class="text col-md-6">
                                <div class="date">
                                    {{ $post->updated_at->format('Y年m月d日') }}
                                </div>
                                <div class="title">
                                    {{ str_limit($post->title, 150) }}
                                </div>
                                <div class="body mt-3">
                                    {{ str_limit($post->body, 1500) }}
                                </div>
                                <div class="image col-md-6 text-right mt-4">
                                @if ($post->image_path)
                                    <img src="{{ asset('storage/image/' . $post->image_path) }}">
                                @endif
                                </div>
                                <ul class="navbar-nav mr-100">
                                    <li><a class="comment-link" href="{{ action('Admin\CommentController@add',$post->id) }}">{{ __('コメントする') }}</a></li>
                                </ul>
                                <hr color="#c0c0c0">
                                
                @foreach($comments as $comment)
                    @if ($comment->develop_id==$post->id)
                            @if ($comment > "0")
                                <p>コメント</p>
                            @endif
                        <div class="body mt-3">
                            {{ str_limit($comment->body, 1500) }}
                            
                             <div>
                                
                                <a href="{{ action('Admin\CommentController@delete', ['id' => $comment->id]) }}">削除</a>
                            </div>
                        </div>
                        <hr color="#c0c0c0">
                    @endif
                @endforeach
                @endforeach
                                
                                
                            </div>
                            
                        </div>
                    </div>
                    <div>
                    </div>
                    <!--<hr color="#c0c0c0">-->
            </div>
        </div>
    </div>
@endsection