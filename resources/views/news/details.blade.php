@extends('layouts.front')

@section('content')

<div class="container">
    <div class="row">
      <div class="col-md-10 offset-md-1 col-12 px-3">
        @foreach($posts as $post)
        <div class="row border-bottom border-dark py-3">
          <!-- 写真 -->
          <div class="col-md-12 col-12">
              <img src="https://cdnspacemarket.com/uploads/attachments/611407/image.jpg?fit=crop&width=600&height=300&bg-color=9c9c9c" style="width: 100%;" class="rounded">
          </div>
          
          
           文章 
          <div class="col-md-8 col-12">
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

            <h6 class="py-2"> コメント一覧 </h6>
            <hr color="#c0c0c0">
            @foreach($comments as $comment)
                    @if ($comment->develop_id==$post->id)
                        <div class="row">
                            <div class="col-md-6 text-left">
                            {{ str_limit($comment->body, 1500) }}
                            </div>
                            
                            <div class="col-md-6 text-right">
                                <a href="{{ action('Admin\CommentController@delete', ['id' => $comment->id]) }}">削除</a>
                            </div>
                        </div>
                        <hr color="#c0c0c0">
                    @endif
            @endforeach



            <div class="row">
              <div class="col-md-8">
                <button class="btn btn-light text-dark"
                    data-toggle="collapse"
                    data-target="#example-1"
                    aria-expand="false"
                    aria-controls="example-1">もっと読む>></button>
                <div class="collapse py-3" id="example-1">
                   <div class="card card-body"> 
                  <p> 029【シェアスペ</p>
                  <p> 029【シェアスペ</p>
                  <p> 029【シェアスペ</p>
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