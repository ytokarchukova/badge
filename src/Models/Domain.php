<?php

namespace YTokarchukova\Badge\Models;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{

    protected $fillable = [
      'name', 'address', 'user_id', 'weekly_email'
    ];

//    public function keywords() {
//        return $this->hasMany('App\Keyword');
//    }

    public function badge() {
        return $this->hasOne(Badge::class);
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public static function getActiveForQueue() {

        return Domain::select('domains.id')
            ->leftJoin('badges', 'domains.id', '=', 'badges.domain_id')
            ->where('badges.status', 1)
            ->get();

    }

    public static function getForUser() {

        return Domain::where('user_id', auth()->user()->id)->get();

    }

}
