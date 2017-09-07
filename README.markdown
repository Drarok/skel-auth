# Skel Auth

This is a basic auth implementation for [Skel][skel].

[skel]: https://github.com/drarok/skel

## Getting started

From within your Skel-based application:

```bash
composer require drarok/skel-auth
```

Then you'll need to create a class that implements extends `AbstractAuthService` (and implements `AuthServiceSchedule`):

```php
<?php

namespace YourApp\Service;

use SkelAuth\Service\AbstractAuthService;

class AuthService extends AbstractAuthService
{
    public function getIdentifierName(): string
    {
        return 'Username';
    }

    public function validateIdentifierAndPassword(string $identifier, string $password): bool
    {
        // You could fetch a user here and use password_verify against their hash
        return $identifier === 'username' && $password === 'password';
    }

    public function getPostLoginRoute(): string
    {
        return 'logged_in';
    }

    public function getPostLogoutRoute(): string
    {
        return 'logged_out';
    }
}
```

Next, register your `AuthService` with the application:

```php
<?php

use YourApp\Service\AuthService;

// …

$app[AuthService::AUTH_SERVICE_KEY] = function ($app) {
    return new AuthService($app['session']);
};
```

Ensure that you either create an `auth/login.html.twig` in your templates directory, or add the path to this module's templates to your Twig configuration.

```php
$app->register(new TwigServiceProvider(), [
    'twig.path' => [
        APP_ROOT . '/templates',
        APP_ROOT . '/vendor/drarok/skel-auth/templates',
    ],
]);
```

And finally, set up your routes!

```php
$app->match('/login', AuthController::class . '::loginAction')
    ->method('GET|POST')
    ->bind('login');

$app->match('/logout', AuthController::class . '::logoutAction')
    ->method('POST')
    ->bind('logout');
```
