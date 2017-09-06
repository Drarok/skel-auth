<?php

namespace SkelAuth;

interface AuthServiceInterface
{
    /**
     * Get the user-facing name of the unique identifier (email, username)
     *
     * @return string
     */
    public function getIdentifierName(): string;

    /**
     * @param string $identifier Unique identifier for a user, such as email or username
     * @param string $password Password as entered by the user
     *
     * @return bool
     */
    public function validateIdentifierAndPassword(string $identifier, string $password): bool;

    /**
     * Get the name of the route to redirect to after logging in.
     *
     * @return string
     */
    public function getPostLoginRoute(): string;

    /**
     * Get the name of the route to redirect to after logging out.
     *
     * @return string
     */
    public function getPostLogoutRoute(): string;
}
