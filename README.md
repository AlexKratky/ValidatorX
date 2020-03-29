# ValidatorX

Class to validate the user inputs.

### Installation

`composer require alexkratky/validatorx`

### Usage

```php
require 'vendor/autoload.php';

use AlexKratky\Validator;
use AlexKratky\IValidator;

Validator::addRule("TestRule", new class implements IValidator {
    public static function validate($input): bool {return ($input === "test");}
});

Validator::customValidate("Alex", "TestRule"); // false
Validator::customValidate("test", "TestRule"); // true
Validator::validate("test", Validator::RULE_CUSTOM, "TestRule"); // true
```