<?php

namespace SkelAuth;

interface UserInterface
{
    /**
     * Validate a password hash
     *
     * @param string $hash
     *
     * @return bool
     */
    public function validatePassword(string $hash): bool;

    /**
     * Get unique id for the user
     *
     * @return int
     */
    public function getId(): int;
}
