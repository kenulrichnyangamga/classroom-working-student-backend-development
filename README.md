# Coding Challenge: PHP Basics – Working Student Backend Developer

Welcome to the comprehensive PHP basics challenge!

To get to know you better as part of your application for a working student position, we have prepared this small, 
practical task. It is designed to let you demonstrate your knowledge of core PHP features and how you approach tasks 
using modern tools like GitHub. Don't worry – it's not about perfection. We are more interested in seeing your 
structured approach and clean, understandable code. You are not required to finish everything, but please show as much 
of your knowledge as you can.

Here’s how it works:

1.  **Fork the Exercise Repository**: Create your own fork of our exercise repository on GitHub. This gives you your own 
    copy where you can try everything out without changing the original. You can find the repository here: 
    [https://github.com/Benefits-me/classroom-working-student-backend-development](https://github.com/Benefits-me/classroom-working-student-backend-development)

2.  **Work on the Challenge**: Take your time to work on the exercise in your fork. We are particularly interested in 
    how you approach the task. Clean, understandable code and brief explanations of your solutions help us to better 
    understand your approach.

3.  **Submit Your Result**: Simply share the link to your repository with us when you're done – it's that easy. We will 
    then look at your solution and get back to you promptly with feedback or the next steps.

If you have any questions at any point, feel free to write to us. Have fun with the task – we look forward to learning more about you and your style!

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