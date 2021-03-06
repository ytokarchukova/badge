# Badge

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require ytokarchukova/badge
$ php artisan migrate
$ php artisan vendor:publish --provider="YTokarchukova\Badge\BadgeServiceProvider"
```

## Usage

> Be Careful! This package not include Controllers.

#### Options

All options in `config/badge.php`

Config Disks in `config/filesystems.php` section `disks`

``` php
         'assets-public' => [
                    'driver' => 'local',
                    'root' => public_path(),
                    'url' => env('APP_URL'),
                    'visibility' => 'public',
         ],
        
         'badges-js' => [
             'driver' => 'local',
             'root' => public_path('badges/js'),
             'url' => env('APP_URL').'/badges/js',
             'visibility' => 'public',
         ],
        
         'badges-img' => [
             'driver' => 'local',
             'root' => public_path('badges/img'),
             'url' => env('APP_URL').'/badges/img',
             'visibility' => 'public',
         ],
        
         'badges-js-s3' => [
             'driver' => 's3',
             'key' => env('AWS_ACCESS_KEY_ID'),
             'secret' => env('AWS_SECRET_ACCESS_KEY'),
             'region' => env('AWS_DEFAULT_REGION'),
             'bucket' => env('AWS_BUCKET'),
             'url' => env('AWS_URL'),
             'root' => 'badges/js/',
         ],
        
         'badges-img-s3' => [
             'driver' => 's3',
             'key' => env('AWS_ACCESS_KEY_ID'),
             'secret' => env('AWS_SECRET_ACCESS_KEY'),
             'region' => env('AWS_DEFAULT_REGION'),
             'bucket' => env('AWS_BUCKET'),
             'url' => env('AWS_URL'),
             'root' => 'badges/img/',
         ],
```

#### Badge (Model)

Field `secret` is Required. Use Helper to fill. Example `Str::random()`

#### BadgeStorage (Model) - Badge Images

Field `file` store only file image name, example `sDJfjkdsSF.png`

#### Cron Checking Badge Status Daily

Config your Laravel Cron to run Artisan Command `php artisan badge:badgesToQueue`.
!!! This feature not working in this revision.

#### Check Badge Status Manually

Import `use YTokarchukova\Badge\Jobs\CheckBadge;`
Run `CheckBadge::dispatch($badge, $check_adress);` where `$badge` is `Badge Model Object` and `$check_address` is url, where crawler search badge.

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email ytokarchukova@gmail.com instead of using the issue tracker.

## Credits

- [Yulia Tokarchukova][link-author]
- [All Contributors][link-contributors]

## License

GPL-3.0-or-later. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/ytokarchukova/badge.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/ytokarchukova/badge.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/ytokarchukova/badge/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/ytokarchukova/badge
[link-downloads]: https://packagist.org/packages/ytokarchukova/badge
[link-travis]: https://travis-ci.org/ytokarchukova/badge
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/ytokarchukova
[link-contributors]: ../../contributors
