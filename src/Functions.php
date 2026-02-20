<?php

declare(strict_types=1);

namespace App;

/**
 * Helper functions for user management.
 * Demonstrates regular functions, closures, and array operations.
 */

/**
 * Regular function: Filter users by their role.
 *
 * array_filter keeps only elements for which the callback returns true.
 *
 * @param array<UserBase> $users The list of users to filter.
 * @param string          $role  The role to filter by.
 * @return array<UserBase> Filtered users matching the role.
 */
function filterUsersByRole(array $users, string $role): array
{
    // array_filter with a closure as callback
    return array_values(array_filter($users, function (UserBase $user) use ($role): bool {
        return $user->getRole() === $role;
    }));
}

/**
 * Regular function: Get a summary of all users as formatted strings.
 *
 * array_map transforms each element by applying a callback.
 * While array_filter removes elements, array_map transforms them.
 *
 * @param array<UserBase> $users The list of users.
 * @return array<string> Array of formatted user summaries.
 */
function getUserSummaries(array $users): array
{
    return array_map(function (UserBase $user): string {
        return sprintf('%s | Role: %s | Permissions: %s',
            $user->getName(),
            $user->getRole(),
            implode(', ', $user->getPermissions())
        );
    }, $users);
}

/**
 * Returns a closure that searches users by partial name match.
 *
 * A closure captures variables from the surrounding scope using `use`.
 * This creates a configurable, reusable search function.
 *
 * @param array<UserBase> $users The user list to search within.
 * @return \Closure A function that accepts a search term and returns matches.
 */
function createUserSearcher(array $users): \Closure
{
    // The returned closure captures $users from this scope
    return function (string $searchTerm) use ($users): array {
        return array_values(array_filter($users, function (UserBase $user) use ($searchTerm): bool {
            // stripos: case-insensitive search
            return stripos($user->getName(), $searchTerm) !== false;
        }));
    };
}

/**
 * Convert a numeric array of users to an associative array keyed by email.
 *
 * Numeric arrays use integer indices (0, 1, 2...) — good for ordered lists.
 * Associative arrays use string keys — ideal for lookups by unique identifier.
 *
 * @param array<int, UserBase> $users Numeric array of users.
 * @return array<string, UserBase> Associative array keyed by email.
 */
function indexUsersByEmail(array $users): array
{
    $indexed = [];

    foreach ($users as $user) {
        // Using email as key allows O(1) lookup
        $indexed[$user->getEmail()] = $user;
    }

    return $indexed;
}

/**
 * Simulate reading user data from a superglobal ($_POST).
 *
 * Superglobals are built-in PHP arrays available in every scope:
 * - $_GET: data from URL query parameters
 * - $_POST: data from form submissions
 * - $_SERVER: server and execution environment info
 *
 * @param array<string, string> $simulatedPost Simulated $_POST data.
 * @return array<string, string> Sanitized user data.
 */
function processUserInput(array $simulatedPost): array
{
    // Always sanitize user input to prevent XSS and injection attacks
    $name = htmlspecialchars(trim($simulatedPost['name'] ?? ''));
    $email = filter_var(trim($simulatedPost['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $role = htmlspecialchars(trim($simulatedPost['role'] ?? 'customer'));

    return [
        'name'  => $name,
        'email' => $email,
        'role'  => $role,
    ];
}
