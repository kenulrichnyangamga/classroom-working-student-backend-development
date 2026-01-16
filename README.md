# Coding Challenge: PHP Basics – Working Student Backend Developer

Welcome to the comprehensive PHP basics challenge!

This assignment is designed to let you demonstrate your knowledge of core PHP features. You are NOT required to finish 
everything — show as much structured PHP knowledge as you can.

---

## Goal

Build a simple user and role management system, demonstrating essential PHP features as outlined below!

---

## Core Tasks

1. **Classes & Properties**
    - Define an abstract class `UserBase` with private/protected/public properties (`name`, `email`).
    - Implement at least two concrete user classes with constructors.

2. **Inheritance, Interfaces, Traits**
    - Use inheritance for user types.
    - Add at least one interface (e.g., `Resettable`), at least one trait (`CanLogin`).

3. **Arrays**
    - Handle user data as both numeric and associative arrays.
    - Use array functions (`array_map`, `array_filter`, etc.).
    - Briefly document in your code when and why each array type is appropriate.

4. **Constants, Static Methods/Properties**
    - Utilize meaningful constants (e.g., `ROLE_ADMIN`), static properties/methods (e.g., a counter of user instances).

5. **Visibility & Methods**
    - Demonstrate private, protected, public properties and methods.
    - Implement basic getters/setters.

6. **Exception Handling**
    - Include example exception handling (e.g., email validation).

7. **Functions & Closures**
    - Write and use a regular function and an anonymous function (closure).

8. **Magic Methods**
    - Implement `__construct`, `__toString`, `__get`, `__set` as examples.

9. **Namespaces & Autoloading**
    - Organize files properly, use namespaces for classes.

10. **Superglobals**
    - Optionally, simulate reading user data from `$_POST` or `$_GET`.

11. **Unit Test / Demo Script**
    - Write a short unit test (as a function or demo script using `assert()`).

12. **PSR-Conformity & Comments**
    - Ensure proper formatting and naming (PSR-1/2), visibility, type hints.
    - Comment code when appropriate.

---

## Suggested Structure

```
src/
  UserBase.php          # Abstract base class for all users
  AdminUser.php         # Example concrete user type
  CustomerUser.php      # Another concrete user type
  Traits/
    CanLogin.php        # Example trait for login logic
  Interfaces/
    Resettable.php      # Example interface for password reset
tests/
.gitignore              # Ignore dependencies, environment, system files
composer.json           # Composer autoload configuration
demo.php                # Demo script to showcase functionality
README.md               # This challenge description
```

**Directory & file explanations:**
- `src/`: All PHP source code files, organized by feature.
- `Traits/`: Place reusable traits (like `CanLogin`) here.
- `Interfaces/`: Place interfaces (like `Resettable`) here.
- `tests/`: Place unit/integration tests here.
- `composer.json`: Autoloading and Composer package config.
- `.gitignore`: Ignore Composer dependencies and project clutter.

Feel free to expand the structure as needed for your solution!

---

## Control Structures & Operators

- Use `if`, `switch`, `foreach`, `while`, and logical operators in your implementation where appropriate.

---

## Requirements & Notes

- Every file should use a namespace and `declare(strict_types=1);`.
- Comment more complex sections.
- Sensible naming and structure are expected.
- The result does not need to be perfectly complete or executable—demonstrating broad PHP basics is most important!
- Code quality is more important than feature-completeness.

---

## Evaluation Criteria

- Breadth and correctness of demonstrated PHP basics
- Readability, structure, PSR compliance
- Sensible comments and example/test code
- Independent and clear solution
- (Optional) Extras like proper type hints or unit tests

---

## How to run the demo script

To test your solution and see example output, use the provided `Demo.php` script in the `tests` folder.

1. Install Composer dependencies for autoloading:
   ```sh
   composer install
   ```

2. Run the demo script using PHP:
   ```sh
   php demo.php
   ```

The demo should print output to your terminal.  
Modify the `demo.php` file to showcase the capabilities of your classes and functions.