<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\UserBase;
use App\AdminUser;
use App\CustomerUser;
use function App\filterUsersByRole;
use function App\getUserSummaries;
use function App\createUserSearcher;
use function App\indexUsersByEmail;
use function App\processUserInput;

echo "=======================================================\n";
echo "  User & Role Management System — Demo\n";
echo "=======================================================\n\n";

// ---------------------------------------------------------------
// 1. Creating users (constructors, inheritance, constants)
// ---------------------------------------------------------------
echo "--- 1. Creating Users ---\n\n";

$admin = new AdminUser('Alice Admin', 'alice@example.com', true);
$manager = new AdminUser('Bob Manager', 'bob@example.com', false);
$customer1 = new CustomerUser('Charlie Customer', 'charlie@example.com', 'premium');
$customer2 = new CustomerUser('Diana User', 'diana@example.com');
$customer3 = new CustomerUser('Eve VIP', 'eve@example.com', 'vip');

// __toString magic method — called automatically with echo
echo "Created: {$admin}\n";
echo "Created: {$manager}\n";
echo "Created: {$customer1}\n";
echo "Created: {$customer2}\n";
echo "Created: {$customer3}\n\n";

// Static method — called on the class, not on an instance
echo "Total users created: " . UserBase::getInstanceCount() . "\n\n";

// ---------------------------------------------------------------
// 2. Magic methods __get and __set
// ---------------------------------------------------------------
echo "--- 2. Magic Methods (__get / __set) ---\n\n";

$admin->department = 'Engineering';
$customer1->loyaltyPoints = 2500;

echo "Admin department: " . $admin->department . "\n";
echo "Customer loyalty points: " . $customer1->loyaltyPoints . "\n";
echo "Undefined property returns null: " . var_export($admin->nonExistent, true) . "\n\n";

// ---------------------------------------------------------------
// 3. Permissions (abstract methods, switch, inheritance)
// ---------------------------------------------------------------
echo "--- 3. Permissions by Role ---\n\n";

echo "Admin (super): " . implode(', ', $admin->getPermissions()) . "\n";
echo "Admin (regular): " . implode(', ', $manager->getPermissions()) . "\n";
echo "Customer (premium): " . implode(', ', $customer1->getPermissions()) . "\n";
echo "Customer (basic): " . implode(', ', $customer2->getPermissions()) . "\n";
echo "Customer (VIP): " . implode(', ', $customer3->getPermissions()) . "\n\n";

// ---------------------------------------------------------------
// 4. Trait: CanLogin
// ---------------------------------------------------------------
echo "--- 4. Login System (Trait: CanLogin) ---\n\n";

echo "Is Alice logged in? " . ($admin->isLoggedIn() ? 'Yes' : 'No') . "\n";

$loginSuccess = $admin->login('alice@example.com', 'securePassword123');
echo "Login attempt: " . ($loginSuccess ? 'Success' : 'Failed') . "\n";
echo "Is Alice logged in now? " . ($admin->isLoggedIn() ? 'Yes' : 'No') . "\n";
echo "Last login: " . $admin->getLastLoginAt() . "\n";

$loginFail = $admin->login('wrong@example.com', 'password');
echo "Login with wrong email: " . ($loginFail ? 'Success' : 'Failed') . "\n";

$admin->logout();
echo "After logout: " . ($admin->isLoggedIn() ? 'Logged in' : 'Logged out') . "\n\n";

// ---------------------------------------------------------------
// 5. Interface: Resettable
// ---------------------------------------------------------------
echo "--- 5. Password Reset (Interface: Resettable) ---\n\n";

$resetOk = $customer1->resetPassword('newSecurePass123');
echo "Password reset (valid): " . ($resetOk ? 'Success' : 'Failed') . "\n";

$resetFail = $customer1->resetPassword('short');
echo "Password reset (too short): " . ($resetFail ? 'Success' : 'Failed') . "\n\n";

// ---------------------------------------------------------------
// 6. Exception handling
// ---------------------------------------------------------------
echo "--- 6. Exception Handling ---\n\n";

try {
    $invalidUser = new CustomerUser('Test', 'not-an-email', 'basic');
} catch (\InvalidArgumentException $e) {
    echo "Caught exception: " . $e->getMessage() . "\n";
}

try {
    $customer2->upgradeMembership('ultra');
} catch (\InvalidArgumentException $e) {
    echo "Caught exception: " . $e->getMessage() . "\n";
}

echo "\n";

// ---------------------------------------------------------------
// 7. Array operations
// ---------------------------------------------------------------
echo "--- 7. Array Operations ---\n\n";

/*
 * Numeric arrays store elements with integer keys (0, 1, 2...).
 * Best for: ordered collections, lists, iterations.
 */
$allUsers = [$admin, $manager, $customer1, $customer2, $customer3];

echo "All users (numeric array, count: " . count($allUsers) . "):\n";

foreach ($allUsers as $index => $user) {
    echo "  [{$index}] {$user->getName()} ({$user->getRole()})\n";
}
echo "\n";

// array_filter — keep only matching users
$admins = filterUsersByRole($allUsers, UserBase::ROLE_ADMIN);
echo "Admins only (array_filter): " . count($admins) . " found\n";

// array_map — transform each user into a summary string
$summaries = getUserSummaries($allUsers);
echo "User summaries (array_map):\n";
foreach ($summaries as $summary) {
    echo "  > {$summary}\n";
}
echo "\n";

/*
 * Associative arrays use string keys for meaningful lookups.
 * Best for: dictionaries, configs, structured data where keys matter.
 */
$usersByEmail = indexUsersByEmail($allUsers);
echo "Lookup by email (associative array):\n";
$found = $usersByEmail['charlie@example.com'] ?? null;
echo "  charlie@example.com > " . ($found ? $found->getName() : 'not found') . "\n\n";

// ---------------------------------------------------------------
// 8. Closure
// ---------------------------------------------------------------
echo "--- 8. Closure (User Search) ---\n\n";

$searcher = createUserSearcher($allUsers);

$results = $searcher('Admin');
echo "Search for 'Admin': " . count($results) . " result(s)\n";foreach ($results as $user) {
    echo "  > {$user->getName()}\n";
}

$results = $searcher('Customer');
echo "Search for 'Customer': " . count($results) . " result(s)\n";
foreach ($results as $user) {
    echo "  > {$user->getName()}\n";
}
echo "\n";

// ---------------------------------------------------------------
// 9. Superglobals simulation
// ---------------------------------------------------------------
echo "--- 9. Superglobals Simulation (\$_POST) ---\n\n";

$simulatedPost = [
    'name'  => '  Frank <script>alert("xss")</script>  ',
    'email' => ' frank@example.com ',
    'role'  => 'customer',
];

$sanitized = processUserInput($simulatedPost);
echo "Raw input name:      '{$simulatedPost['name']}'\n";
echo "Sanitized name:      '{$sanitized['name']}'\n";
echo "Sanitized email:     '{$sanitized['email']}'\n\n";

// ---------------------------------------------------------------
// 10. toArray — object to associative array
// ---------------------------------------------------------------
echo "--- 10. User as Associative Array ---\n\n";

$adminArray = $admin->toArray();
foreach ($adminArray as $key => $value) {
    $display = is_array($value) ? implode(', ', $value) : var_export($value, true);
    echo "  {$key}: {$display}\n";
}
echo "\n";

echo "=======================================================\n";
echo "  Demo complete! All PHP basics demonstrated.\n";
echo "=======================================================\n";
