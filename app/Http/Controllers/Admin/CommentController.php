<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Comment;

class CommentController extends Controller
{
    public function add($id)
  {
    // \Debugbar::info($id);
    // var_dump($id);
      return view('admin.comment.create', ['develop_id' => $id]);
      // return view('admin.comment.create');
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
    
    public function delete(Request $request)
  {
      \Debugbar::info($request);
      // 該当するNews Modelを取得
      $comments = Comment::find($request->id);
      // 削除する
      $comments->delete();
      return redirect('/');
  }  
}
