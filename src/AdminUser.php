<?php

declare(strict_types=1);

namespace App;



class AdminUser extends UserBase
{
    /** @var bool Whether this admin can manage other admins. */
    private bool $isSuperAdmin;

    /**
     * @param string $name         The admin's full name.
     * @param string $email        The admin's email address.
     * @param bool   $isSuperAdmin Whether this admin has super admin privileges.
     */
    public function __construct(string $name, string $email, bool $isSuperAdmin = false)
    {
        // Call the parent constructor to initialize base properties
        parent::__construct($name, $email, self::ROLE_ADMIN);
        $this->isSuperAdmin = $isSuperAdmin;
    }

    /**
     * Implementation of the abstract method from UserBase.
     * Admins have full system permissions.
     *
     * @return array<string> List of admin permissions.
     */
    public function getPermissions(): array
    {
        $permissions = ['read', 'write', 'delete', 'manage_users'];

        // Super admins get additional permissions
        if ($this->isSuperAdmin) {
            $permissions[] = 'manage_admins';
            $permissions[] = 'system_settings';
        }

        return $permissions;
    }

    public function isSuperAdmin(): bool
    {
        return $this->isSuperAdmin;
    }

    /**
     * Admin-specific method: promote a user.
     * Only available on AdminUser, not on CustomerUser.
     */
    public function promoteUser(UserBase $user): string
    {
        return sprintf('%s has been promoted by admin %s.', $user->getName(), $this->getName());
    }
}
