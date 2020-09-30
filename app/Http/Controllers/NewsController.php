<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\HTML;

// 追記
use App\Develop;
use App\Comment;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $posts = Develop::all()->sortByDesc('updated_at');

        // if (count($posts) > 0) {
        //     $headline = $posts->shift();
        // } else {
        //     $headline = null;
        // }
        $comments = Comment::all()->sortByDesc('updated_at');
        
        \Debugbar::info($posts);
        
        // news/index.blade.php ファイルを渡している
        // また View テンプレートに headline、 posts、という変数を渡している
        return view('news.index', ['posts' => $posts, 'comments' => $comments ]);
    }
    
    public function details()
    {
        $posts = Develop::all()->sortByDesc('updated_at');
        
        $comments = Comment::all()->sortByDesc('updated_at');
        return view('news.details', ['posts' => $posts, 'comments' => $comments ]);
    }
    
    // public function Prefectures()
    // {
    //     $prefs = config('pref');
    //     return view('news.details')->with(['prefs' => $prefs]);
    // }
    
}