<?php

declare(strict_types=1);

namespace App\Traits;

trait CanLogin
{
    /** @var bool Tracks whether the user is currently logged in. */
    private bool $isLoggedIn = false;

    /** @var string|null Stores the timestamp of the last login. */
    private ?string $lastLoginAt = null;

    /**
     * Simulate a user login with email and password validation.
     */
    public function login(string $email, string $password): bool
    {
        // Check if the provided email matches the user's email
        if ($email !== $this->getEmail()) {
            return false;
        }

        // In a real app, we would verify the hashed password here
        if (empty($password)) {
            return false;
        }

        $this->isLoggedIn = true;
        $this->lastLoginAt = date('Y-m-d H:i:s');

        return true;
    }

    /**
     * Log the user out.
     */
    public function logout(): void
    {
        $this->isLoggedIn = false;
    }

    /**
     * Check if the user is currently logged in.
     */
    public function isLoggedIn(): bool
    {
        return $this->isLoggedIn;
    }

    /**
     * Get the timestamp of the last successful login.
     */
    public function getLastLoginAt(): ?string
    {
        return $this->lastLoginAt;
    }
}
