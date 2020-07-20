<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Develop;

class DevelopController extends Controller
{
    public function add()
  {
      return view('admin.develop.create');
  }
  
  public function create(Request $request)
  {
      $this->validate($request, Develop::$rules);

      $develop = new Develop;
      $form = $request->all();

      // フォームから画像が送信されてきたら、保存して、$news->image_path に画像のパスを保存する
      if (isset($form['image'])) {
        $path = $request->file('image')->store('public/image');
        $develop->image_path = basename($path);
      } else {
          $develop->image_path = null;
      }

      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
      // フォームから送信されてきたimageを削除する
      unset($form['image']);

      // データベースに保存する
      $develop->fill($form);
      $develop->save();

      return redirect('admin/develop/create');
  }  
  
  public function index(Request $request)
  {
      $cond_title = $request->cond_title;
      if ($cond_title != '') {
          // 検索されたら検索結果を取得する
          $posts = Develop::where('title', $cond_title)->get();
      } else {
          // それ以外はすべてのニュースを取得する
          $posts = Develop::all();
      }
      return view('admin.develop.index', ['posts' => $posts, 'cond_title' => $cond_title]);
  }
  
  public function edit(Request $request)
  {
      // News Modelからデータを取得する
      $develop = Develop::find($request->id);
      if (empty($develop)) {
        abort(404);    
      }
      return view('admin.develop.edit', ['develop_form' => $develop]);
  }


  public function update(Request $request)
  {
      // Validationをかける
      $this->validate($request, Develop::$rules);
      // News Modelからデータを取得する
      $develop = Develop::find($request->id);
      // 送信されてきたフォームデータを格納する
      $develop_form = $request->all();
      if (isset($develop_form['image'])) {
        $path = $request->file('image')->store('public/image');
        $develop->image_path = basename($path);
        unset($develop_form['image']);
      } elseif (isset($request->remove)) {
        $develop->image_path = null;
        unset($develop_form['remove']);
      }
      unset($develop_form['_token']);
      // 該当するデータを上書きして保存する
      $develop->fill($develop_form)->save();

      return redirect('admin/develop');
  }
}
