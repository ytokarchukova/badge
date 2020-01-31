<?php

namespace YTokarchukova\Badge\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Badge extends Model
{

    protected $fillable = ['domain_id', 'secret', 'badge_storage_id'];

    public function domain() {
        return $this->belongsTo(Domain::class);
    }

    public function image() {
        return $this->belongsTo(BadgeStorage::class, 'badge_storage_id');
    }

    public static function getForUser() {

        return Badge::select('badges.id', 'badges.domain_id', 'badges.badge_storage_id', 'badges.status', 'badges.updated_at', 'domains.address AS domain_address')
            ->leftJoin('domains', 'badges.domain_id', '=', 'domains.id')
            ->where('domains.user_id', auth()->user()->id)
            ->get();

    }

    public static function generate($domain_id) {

        $badge = Badge::create([
            'domain_id' => $domain_id,
            'secret' => Str::random(),
        ]);

        Badge::generateJsFile($badge);

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
