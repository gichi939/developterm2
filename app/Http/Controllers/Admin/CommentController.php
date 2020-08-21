<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Comment;

class CommentController extends Controller
{
    public function add()
  {
      return view('admin.comment.create');
  }
  
  public function create(Request $request)
  {
    // 以下を追記
    // Varidationを行う
    $this->validate($request, Comment::$rules);
    
    $comment = new Comment;
    $form = $request->all();
    
    // フォームから送信されてきた_tokenを削除する
    unset($form['_token']);
    
    // データベースに保存する
    $comment->fill($form);
    $comment->save();
    
    return redirect('/');
    }
}
