# Laravel API Foundation

Small Laravel package for consistent APIs: versioned routes (e.g. `/api/v1/`), standard JSON response and error format, and pagination. Use it so all your endpoints look and behave the same.

## Install

```bash
composer require tpjasar/laravel-api-foundation
```

Publish config (optional):

```bash
php artisan vendor:publish --tag=api-foundation-config
```

## Versioned routes

Any version works: `/api/v1/...`, `/api/v2/...`, `/api/v3/...` — no config needed. Add new versions anytime by just using them in the URL.

In `App\Providers\RouteServiceProvider` or `routes/api.php`:

```php
use Tpjasar\ApiFoundation\Route\VersionedRoute;

VersionedRoute::register(function () {
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show']);
});
```

This registers `/api/v1/users`, `/api/v2/users`, `/api/v3/users`, etc. Get the current version in your handler: `request()->route('version')`.

## Response format

Use the helper so success responses look the same:

```php
use Tpjasar\ApiFoundation\Response\ApiResponse;

return ApiResponse::success($user, 'User found');
// { "data": {...}, "message": "User found" }

return ApiResponse::success($users);
// { "data": [...] }
```

## Error format

```php
return ApiResponse::error('Not found', 404, null, 404);
// { "error": { "code": 404, "message": "Not found" } }

return ApiResponse::error('Validation failed', 422, $validator->errors(), 422);
// { "error": { "code": 422, "message": "Validation failed", "details": {...} } }
```

## Pagination

```php
$users = User::paginate(15);
return ApiResponse::paginated($users);
// { "data": [...], "meta": { "current_page": 1, "per_page": 15, "total": 50, "last_page": 4 } }
```

## Config

`config/api-foundation.php` (after publish):

- `prefix` – API prefix (default `api`)
- Versions are automatic (v1, v2, v3, …); no list to maintain
- `response.data_key`, `error_key`, etc. – Keys used in JSON
- `pagination.*` – Keys for pagination meta

## License

MIT

## Author

Muhammad Jasar T P
