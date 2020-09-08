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
        
        // news/index.blade.php ファイルを渡している
        // また View テンプレートに headline、 posts、という変数を渡している
        return view('news.index', ['posts' => $posts, 'comments' => $comments ]);
    }
    
}