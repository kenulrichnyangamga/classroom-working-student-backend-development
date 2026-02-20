<?php

declare(strict_types=1);

namespace App\Interfaces;

/**
 * Interface Resettable
 *
 * Contract for any class that supports password reset functionality.
 * Classes implementing this interface must provide a resetPassword method.
 */
interface Resettable
{
    /**
     * Reset the user's password to a new value.
     *
     * @param string $newPassword The new password to set.
     * @return bool True if the reset was successful, false otherwise.
     */
    public function resetPassword(string $newPassword): bool;
}
