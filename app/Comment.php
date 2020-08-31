<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
        'develop_id' => 'required',
        'body' => 'required'
    );
    
    public function develop()
  {
    // return $this->belongsTo(Develop::class);
    return $this->belongsTo('App\Develop');
  }
}
