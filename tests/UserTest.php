<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\UserBase;
use App\AdminUser;
use App\CustomerUser;
use function App\filterUsersByRole;
use function App\getUserSummaries;
use function App\createUserSearcher;
use function App\indexUsersByEmail;
use function App\processUserInput;

echo "Running tests...\n\n";

UserBase::resetInstanceCount();

// Test 1: User creation
$admin = new AdminUser('Test Admin', 'admin@test.com', true);
assert($admin->getName() === 'Test Admin');
assert($admin->getEmail() === 'admin@test.com');
assert($admin->getRole() === UserBase::ROLE_ADMIN);
echo "Test 1 passed: User creation and properties\n";

// Test 2: Static instance counter
$customer = new CustomerUser('Test Customer', 'customer@test.com');
assert(UserBase::getInstanceCount() === 2);
echo "Test 2 passed: Static instance counter\n";

// Test 3: Email validation exception
$exceptionThrown = false;
try {
    new CustomerUser('Bad', 'not-valid', 'basic');
} catch (\InvalidArgumentException $e) {
    $exceptionThrown = true;
}
assert($exceptionThrown === true);
echo "Test 3 passed: Email validation throws exception\n";

// Test 4: Permissions
$superAdmin = new AdminUser('Super', 'super@test.com', true);
$basicCustomer = new CustomerUser('Basic', 'basic@test.com', 'basic');
$vipCustomer = new CustomerUser('VIP', 'vip@test.com', 'vip');

assert(in_array('manage_admins', $superAdmin->getPermissions()));
assert(!in_array('write_reviews', $basicCustomer->getPermissions()));
assert(in_array('exclusive_content', $vipCustomer->getPermissions()));
echo "Test 4 passed: Permissions by role and level\n";

// Test 5: CanLogin trait
assert($admin->isLoggedIn() === false);
$admin->login('admin@test.com', 'password123');
assert($admin->isLoggedIn() === true);
$admin->logout();
assert($admin->isLoggedIn() === false);
$result = $admin->login('wrong@test.com', 'password123');
assert($result === false);
echo "Test 5 passed: Login/logout trait\n";

// Test 6: Resettable interface
assert($customer->resetPassword('longEnoughPassword') === true);
assert($customer->resetPassword('short') === false);
echo "Test 6 passed: Password reset interface\n";

// Test 7: Magic methods
$str = (string) $admin;
assert(str_contains($str, 'Test Admin'));
$admin->customField = 'custom_value';
assert($admin->customField === 'custom_value');
assert($admin->undefinedField === null);
echo "Test 7 passed: Magic methods\n";

// Test 8: Array functions
$allUsers = [$admin, $customer, $superAdmin, $basicCustomer, $vipCustomer];
$admins = filterUsersByRole($allUsers, UserBase::ROLE_ADMIN);
assert(count($admins) === 2);

$summaries = getUserSummaries($allUsers);
assert(count($summaries) === count($allUsers));

$searcher = createUserSearcher($allUsers);
$found = $searcher('Super');
assert(count($found) === 1);

$indexed = indexUsersByEmail($allUsers);
assert(isset($indexed['admin@test.com']));
echo "Test 8 passed: Array functions and closures\n";

// Test 9: Membership upgrade
$basicCustomer->upgradeMembership('premium');
assert($basicCustomer->getMembershipLevel() === 'premium');
$upgradeException = false;
try {
    $basicCustomer->upgradeMembership('invalid');
} catch (\InvalidArgumentException $e) {
    $upgradeException = true;
}
assert($upgradeException === true);
echo "Test 9 passed: Membership upgrade with validation\n";

// Test 10: Input sanitization
$input = processUserInput([
    'name'  => '  <script>alert("xss")</script>  ',
    'email' => ' test@example.com ',
]);
assert($input['name'] !== '<script>alert("xss")</script>');
assert($input['email'] === 'test@example.com');
echo "Test 10 passed: Input sanitization\n";

// Test 11: toArray
$arr = $admin->toArray();
assert(array_key_exists('name', $arr));
assert(array_key_exists('email', $arr));
assert(array_key_exists('permissions', $arr));
echo "Test 11 passed: toArray conversion\n";

echo "\n========================================\n";
echo "  All tests passed!\n";
echo "========================================\n";

