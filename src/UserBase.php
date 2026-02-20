<?php

declare(strict_types=1);

namespace App;

use App\Interfaces\Resettable;
use App\Traits\CanLogin;

/**
 * Abstract class UserBase
 *
 * Base class for all user types in the system.
 * Cannot be instantiated directly — child classes must implement abstract methods.
 */
abstract class UserBase implements Resettable
{
    use CanLogin;

    /**
     * Constants for user roles.
     * Constants are immutable values — useful for fixed identifiers.
     */
    public const ROLE_ADMIN = 'admin';
    public const ROLE_CUSTOMER = 'customer';

    /**
     * Static property: counts how many user instances have been created.
     * Static properties belong to the class itself, not to individual objects.
     */
    private static int $instanceCount = 0;

    /**
     * Private: only accessible within this class (not even child classes).
     */
    private string $email;

    /**
     * Protected: accessible within this class AND child classes.
     */
    protected string $name;

    /**
     * Public: accessible from anywhere.
     */
    public string $role;

    /** @var string Stores the user's hashed password. */
    private string $password;

    /**
     * @var array<string, mixed> Storage for dynamic properties via __get/__set.
     */
    private array $extraData = [];

    /**
     
    
     * @throws \InvalidArgumentException If the email format is invalid.
     */
    public function __construct(string $name, string $email, string $role)
    {
        // Validate email — demonstrates exception handling
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(
                "Invalid email format: '{$email}'."
            );
        }

        $this->name = $name;
        $this->email = $email;
        $this->role = $role;
        $this->password = '';

        self::$instanceCount++;
    }

    
    public function __toString(): string
    {
        return sprintf('[%s] %s (%s)', ucfirst($this->role), $this->name, $this->email);
    }

   
    public function __get(string $property): mixed
    {
        return $this->extraData[$property] ?? null;
    }

  
    public function __set(string $property, mixed $value): void
    {
        $this->extraData[$property] = $value;
    }

   

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @throws \InvalidArgumentException If the new email is invalid.
     */
    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Invalid email format: '{$email}'.");
        }
        $this->email = $email;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    // --- Interface: Resettable ---

    /**
     * Reset the user's password. Implements the Resettable contract.
     */
    public function resetPassword(string $newPassword): bool
    {
        if (strlen($newPassword) < 8) {
            return false;
        }

        $this->password = password_hash($newPassword, PASSWORD_DEFAULT);
        return true;
    }

    // --- Static methods ---

    /**
     * Get total number of user instances created.
     * Called on the class: UserBase::getInstanceCount()
     */
    public static function getInstanceCount(): int
    {
        return self::$instanceCount;
    }

    /**
     * Reset the instance counter (useful for testing).
     */
    public static function resetInstanceCount(): void
    {
        self::$instanceCount = 0;
    }

    // --- Abstract method ---

    /**
     * Get permissions for this user type.
     * Each child class must implement this.
     *
     * @return array<string> List of permission strings.
     */
    abstract public function getPermissions(): array;

    /**
     * Convert user to an associative array.
     * Associative arrays use string keys — ideal for structured data.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name'        => $this->name,
            'email'       => $this->email,
            'role'        => $this->role,
            'permissions' => $this->getPermissions(),
            'logged_in'   => $this->isLoggedIn(),
        ];
    }
}