<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Develop;
use App\Like;
use Storage;

use App\History;

use Carbon\Carbon;

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
      // dd($form['image']);
      // フォームから画像が送信されてきたら、保存して、$news->image_path に画像のパスを保存する
      if (isset($form['image'])) {
        $image = $request->file('image');
        // dd($image);
        $path = Storage::disk('s3')->putfile('/newapp-giichi',$image,'public');
        $develop->image_path = Storage::disk('s3')->url($path);
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

      return redirect('/');
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
        $path = Storage::disk('s3')->putFile('/',$form['image'],'public');
        $news->image_path = Storage::disk('s3')->url($path);
        unset($develop_form['image']);
      } elseif (isset($request->remove)) {
        $develop->image_path = null;
        unset($develop_form['remove']);
      }
      unset($develop_form['_token']);
      // 該当するデータを上書きして保存する
      $develop->fill($develop_form)->save();
      
      $history = new History;
        $history->develop_id = $develop->id;
        $history->edited_at = Carbon::now();
        $history->save();

      return redirect('admin/develop');
  }
  
  public function delete(Request $request)
  {
      // 該当するNews Modelを取得
      $develop = Develop::find($request->id);
      // 削除する
      $develop->delete();
      return redirect('admin/develop/');
  }
  
  public function like($id)
  {
    // \Debugbar::info($id);
    $like = new Like;
    $like->user_id = Auth::id();
    $like->develop_id = $id;
    $like->save();
    // Like::create([
    //   'develop_id' => $id,
    //   'user_id' => Auth::id(),
    // ]);

    session()->flash('success', 'You Liked the Reply.');
    return redirect()->back();
  }

  /**
   * 引数のIDに紐づくリプライにUNLIKEする
   *
   * @param $id リプライID
   * @return \Illuminate\Http\RedirectResponse
   */
  public function unlike($id)
  {
    $like = Like::where('develop_id', $id)->where('user_id', Auth::id())->first();
    $like->delete();

    session()->flash('success', 'You Unliked the Reply.');

    return redirect()->back();
  }
  
  
}
