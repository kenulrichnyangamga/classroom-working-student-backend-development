<?php

declare(strict_types=1);

namespace App;

/**
 * Class CustomerUser
 *
 * Represents a regular customer with limited permissions.
 * Demonstrates inheritance with different behaviors than AdminUser.
 */
class CustomerUser extends UserBase
{
    /** @var string The customer's membership level. */
    private string $membershipLevel;

    /**
     * @param string $name            The customer's full name.
     * @param string $email           The customer's email address.
     * @param string $membershipLevel Membership tier: 'basic', 'premium', or 'vip'.
     */
    public function __construct(string $name, string $email, string $membershipLevel = 'basic')
    {
        parent::__construct($name, $email, self::ROLE_CUSTOMER);
        $this->membershipLevel = $membershipLevel;
    }

    /**
     * Implementation of the abstract method from UserBase.
     * Permissions depend on membership level — demonstrates switch control structure.
     *
     * @return array<string> List of customer permissions.
     */
    public function getPermissions(): array
    {
        $permissions = ['read', 'view_profile'];

        switch ($this->membershipLevel) {
            case 'vip':
                $permissions[] = 'priority_support';
                $permissions[] = 'exclusive_content';
                // VIP also gets premium perks — intentional fall-through
                // no break
            case 'premium':
                $permissions[] = 'write_reviews';
                $permissions[] = 'early_access';
                break;
            case 'basic':
            default:
                // Basic members only get default permissions
                break;
        }

        return $permissions;
    }

    public function getMembershipLevel(): string
    {
        return $this->membershipLevel;
    }

    /**
     * Upgrade the customer's membership level.
     *
     * @throws \InvalidArgumentException If the level is not valid.
     */
    public function upgradeMembership(string $newLevel): void
    {
        $validLevels = ['basic', 'premium', 'vip'];

        if (!in_array($newLevel, $validLevels, true)) {
            throw new \InvalidArgumentException(
                "Invalid membership level: '{$newLevel}'. Must be one of: "
                . implode(', ', $validLevels)
            );
        }

        $this->membershipLevel = $newLevel;
    }
}
