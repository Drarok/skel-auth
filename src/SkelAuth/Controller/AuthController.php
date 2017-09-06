<?php

namespace SkelAuth\Controller;

use Silex\Application;
use SkelAuth\AuthServiceInterface;
use SkelAuth\Service\AbstractAuthService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Twig_Environment;

class AuthController
{
    const IDENTIFIER_KEY = 'identifier';
    const PASSWORD_KEY = 'password';

    public function loginAction(Application $app, Request $request)
    {
        /** @var AbstractAuthService $auth */
        $auth = $app[AbstractAuthService::APP_KEY];

        $loginFailed = false;

        if ($request->getMethod() === Request::METHOD_POST) {
            $identifier = $request->request->get(self::IDENTIFIER_KEY);
            $password = $request->request->get(self::PASSWORD_KEY);

            if ($auth->validateIdentifierAndPassword($identifier, $password)) {
                $auth->setCurrentUserIdentifier($identifier);

                /** @var UrlGenerator $url */
                $generator  = $app['url_generator'];
                $url = $generator->generate($auth->getPostLoginRoute());
                return $app->redirect($url);
            } else {
                $loginFailed = true;
            }
        }

        /** @var Twig_Environment $twig */
        $twig = $app['twig'];
        return $twig->render('auth/login.html.twig', [
            'identifierName' => $auth->getIdentifierName(),
            'loginFailed' => $loginFailed,
        ]);
    }

    public function logoutAction(Application $app)
    {
        /** @var AbstractAuthService $auth */
        $auth = $app[AbstractAuthService::APP_KEY];

        $auth->clearCurrentUserIdentifier();

        /** @var UrlGenerator $url */
        $generator  = $app['url_generator'];
        $url = $generator->generate($auth->getPostLogoutRoute());
        return $app->redirect($url);
    }
}
