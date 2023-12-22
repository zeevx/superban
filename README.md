![superban](https://banners.beyondco.de/Superban.png?theme=light&packageManager=composer+require&packageName=zeevx%2Fsuperban&pattern=cage&style=style_1&description=Add+the+ability+to+ban+a+client+completely+from+accessing+your+app+routes+for+a+period+of+time.&md=1&showWatermark=1&fontSize=100px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg&widths=100&heights=100)

## Laravel Superban .

[![Latest Version on Packagist](https://img.shields.io/packagist/v/zeevx/superban.svg?style=flat-square)](https://packagist.org/packages/zeevx/superban)
[![Total Downloads](https://img.shields.io/packagist/dt/zeevx/superban.svg?style=flat-square)](https://packagist.org/packages/zeevx/superban)

Add the ability to ban a client completely from accessing your app routes for a period of time.

## Installation

You can install the package via composer:

```bash
composer require zeevx/superban
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="superban-config"
```

To use middleware add them inside your app/Http/Kernel.php :

```bash
    protected $routeMiddleware = [
        'superban' => \Zeevx\Superban\Middlewares\SuperbanMiddleware::class,
    ];
```

This is the contents of the published config file:

```php
return [
/**
     * Key used in cache
     * The default is ip_address, you can use either: ip_address or email or user_id
     *
     */
    'key' => 'ip_address',

    /**
     * The cache to be used,
     * The default cache in config/cache.php is used if empty.
     */
    'cache' => 'file',

    /**
     * Specify guard to be used if you are using email or user_id
     * The default guard in config/auth.php is used if empty
     */
    'user_guard' => '',

    /**
     * Enable email notification for when a user is banned
     *
     */
    'enable_email_notification' => true,

    /**
     * Email address to be used for email notification
     *
     */
    'email_address' => '',
];
```

## Usage
Apply the middleware to any route in this format:

X - Number of request

Y - Within what period (in minutes)

Z- How long the user should be banned (in minutes).

```php
Route::middleware(['superban:X,Y,Z])->group(function () {
   Route::post('/thisroute', function () {
       // ...
   });
 
   Route::post('anotherroute', function () {
       // ...
   });
});
```

## Testing

```bash
composer test
```

## Credits

- [Paul Adams](https://github.com/zeevx)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
