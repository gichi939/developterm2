<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Like;

class Develop extends Model
{
    protected $guarded = array('id');

    // 以下を追記
    public static $rules = array(
        'title' => 'required',
        'body' => 'required',
    );
    
    public function histories()
    {
        return $this->hasMany('App\History');

    }
    
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
    
    public function likes()
    {
        return $this->hasMany(Like::class, 'develop_id');
    }
    
    public function is_liked_by_auth_user()
  {
    $id = Auth::id();

    $likers = array();
    foreach($this->likes as $like) {
      array_push($likers, $like->user_id);
    }

    if (in_array($id, $likers)) {
      return true;
    } else {
      return false;
    }
  }
}