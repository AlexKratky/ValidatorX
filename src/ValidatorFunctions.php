<?php
/**
 * @name ValidatorFunctions.php
 * @link https://alexkratky.com                         Author website
 * @link https://panx.eu/docs/                          Documentation
 * @link https://github.com/AlexKratky/ValidatorX/      Github Repository
 * @author Alex Kratky <alex@panx.dev>
 * @copyright Copyright (c) 2020 Alex Kratky
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @description Class that loads custom functions. Part of panx-framework.
 */

declare (strict_types = 1);

namespace AlexKratky;

use AlexKratky\IValidator;
use AlexKratky\MissingValidatorException;

class ValidatorFunctions {

    protected static $customValidators = [];
    protected static $throwError = false;

    /**
     * Adds a new custom rule.
     * @param string $name Rule name.
     * @param IValidator $validator Validator class. 
     */
    public static function addRule(string $name, IValidator $validator) {
        self::$customValidators[$name] = $validator;
    }

    /**
     * Custom validate.
     * @return bool Return true if $input is valid, false otherwise.
     */
    public static function customValidate($input, string $validator): bool {
        if(!self::validatorExists($validator)) return false;
        return self::$customValidators[$validator]::validate($input);
    }

    /**
     * Check if validator exists.
     * @return bool Return true if yes, false otherwise.
     */
    public static function validatorExists(string $validator) {
        if(self::$throwError && empty(self::$customValidators[$validator])) throw new MissingValidatorException($validator);
        return (!empty(self::$customValidators[$validator]));
    }

    /**
     * @param bool $throwError If sets to true: validatorExists() throws error whenever Validator does not exists. If sets to false: validatorExists() returns false. By default is set to false.
     */
    public static function setThrowError($throwError = true) {self::$throwError = $throwError;}

}
