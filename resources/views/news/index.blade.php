@extends('layouts.front')

@section('content')
    <div class="container">
    <div class="row">
      <div class="col-md-8 offset-md-2 col-12 px-3">
        @foreach($posts as $post)
        <div class="row text-center py-3">
            <div class="col-md-12 col-12">
                @if ($post->image_path)
                    <img src="{{ asset('storage/image/' . $post->image_path) }}"style="width: 100%;" class="rounded">
                @else
                    <img src="https://www.shoshinsha-design.com/wp-content/uploads/2016/10/%E3%82%B9%E3%82%AF%E3%83%AA%E3%83%BC%E3%83%B3%E3%82%B7%E3%83%A7%E3%83%83%E3%83%88-2016-10-05-0.41.12.png"style="width: 100%;" class="rounded">
                @endif
            </div>
        </div>
        <!--<p>{{$loop->index}}</p>-->
        <div class="row border-bottom border-dark py-3">
          <!-- 文章 -->
          <div class="col-md-12 col-12">
            <div class="row">
            <div class="col-md-6 text-left">
                <p class="date">
                {{ $post->updated_at->format('Y年m月d日') }}
                </p>
                <p class="title">
                {{ str_limit($post->title, 150) }}
                </p>
                <p class="body mt-3">
                    {{ str_limit($post->body, 1500) }}
                </p>
            </div>
              <div class="col-12 col-md-6 text-right">
                <a class="comment-link" href="{{ action('Admin\CommentController@add',$post->id) }}">
                  <i class="material-icons" style="font-size: 42px;">comment</i>
                </a>
                @if($post->is_liked_by_auth_user())
                  <a href="{{ route('reply.unlike', ['id' => $post->id]) }}" class="">
                      <i class="material-icons" style="font-size: 42px; color:red;">favorite</i>
                      <span class="badge">{{ $post->likes->count() }}</span>
                　</a>
                @else
                  <a href="{{ route('reply.like', ['id' => $post->id]) }}" class="">
                       <i class="material-icons" style="font-size: 42px; color:red;">favorite_border</i>
                      <span class="badge">{{ $post->likes->count() }}</span>
                　</a>
                @endif

              </div>
            </div>

            <!--<h6 class="py-2"> コメント一覧 </h6>-->
            <hr color="#c0c0c0">


            <div class="row">
              <div class="col-md-12">
                <button class="btn btn-light text-dark"
                    data-toggle="collapse"
                    data-target="#example-{{$loop->index}}"
                    aria-expand="false"
                    aria-controls="example-{{$loop->index}}">コメントを読む({{ $comments->count() }})>></button>
                <div class="collapse py-3" id="example-{{$loop->index}}">
                   <div class="card card-body"> 
                    @foreach($comments as $comment)
                            @if ($comment->develop_id==$post->id)
                                <div class="row">
                                    <div class="col-md-12">
                                        {{ str_limit($comment->body, 1500) }}
                                        <a href="{{ action('Admin\CommentController@delete', ['id' => $comment->id]) }}">削除</a>
                                    </div>
                                </div>
                                <!--<hr color="#c0c0c0">-->
                            @endif
                    @endforeach
                   </div> 
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach

      </div>
    </div>
  </div>
@endsection