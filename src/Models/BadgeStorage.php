<?php

namespace YTokarchukova\Badge\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BadgeStorage extends Model
{

    public $timestamps = false;
    protected $fillable = ['file'];

    public static function getWithImgUrl() {

        $badges_images = BadgeStorage::all();

        return $badges_images->map(function($badgeImg) {
            return [
                'id' => $badgeImg->id,
                'url' => Storage::disk(config('badge.storage_img'))->url($badgeImg->file),
            ];
        });

    }

    public static function getFirstImgId() {

        return BadgeStorage::first()->value('id');

    }

}
