<?php

namespace SkelAuth\Service;

use SkelAuth\AuthServiceInterface;
use Symfony\Component\HttpFoundation\Session\Session;

abstract class AbstractAuthService implements AuthServiceInterface
{
    const APP_KEY = 'skel_auth_service';
    const SESSION_KEY = 'skel_auth';

    /**
     * @var Session
     */
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    protected function getSession(): Session
    {
        return $this->session;
    }

    public function setCurrentUserIdentifier($identifier)
    {
        $this->getSession()->set(self::SESSION_KEY, $identifier);
    }

    public function getCurrentUserIdentifier()
    {
        return $this->getSession()->get(self::SESSION_KEY, false);
    }

    public function clearCurrentUserIdentifier()
    {
        $this->getSession()->remove(self::SESSION_KEY);
    }
}
