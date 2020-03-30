<?php

namespace YTokarchukova\Badge\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Badge extends Model
{

    protected $fillable = ['secret', 'badge_storage_id'];

    public function image() {
        return $this->belongsTo(BadgeStorage::class, 'badge_storage_id');
    }

    public static function generate() {

        $badge = Badge::create([
            'secret' => Str::random(),
        ]);

        Badge::generateJsFile($badge);

    }

    public static function regenerateAll() {

        $badges = Badge::all();

        foreach ($badges as $badge) {

            Badge::generateJsFile($badge);

        }

    }

    public static function generateJsFile(Badge $badge) {

        $badge_options = Badge::getConfigForJs();

        if ($badge->badge_storage_id !== null) {
            $badge_img_url = Storage::disk(config('badge.storage_img'))->url($badge->image->file);
        } else {
            $badge_img_url = config('badge.default_img_url');
        }

        Storage::disk(config('badge.storage_js'))->put($badge->secret.'.js', view('ytokarchukova::badge-js', compact('badge_img_url', 'badge_options'))->renderSections()['js']);

    }

    public static function setDefaultImg($badge_storage_id) {

        $default_img_id = BadgeStorage::getFirstImgId();

        return Badge::where('badge_storage_id', $badge_storage_id)->update(['badge_storage_id' => $default_img_id]);

    }

    public static function getConfigForJs() {

        return [
            'badge_link_url' => config('badge.link_url'),
            'badge_link_target' => config('badge.link_target'),
            'badge_img_alt' => config('badge.img_alt'),
        ];

    }

}
