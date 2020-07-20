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
}
