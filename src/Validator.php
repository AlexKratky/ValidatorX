<?php
/**
 * @name Validator.php
 * @link https://alexkratky.com                         Author website
 * @link https://panx.eu/docs/                          Documentation
 * @link https://github.com/AlexKratky/ValidatorX/      Github Repository
 * @author Alex Kratky <alex@panx.dev>
 * @copyright Copyright (c) 2020 Alex Kratky
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @description Class to validate the user inputs. Part of panx-framework.
 */

declare (strict_types = 1);

namespace AlexKratky;

use AlexKratky\ValidatorFunctions;

class Validator extends ValidatorFunctions
{
    public const RULE_CUSTOM = 0;
    public const RULE_MAIL = 1;
    public const RULE_USERNAME = 2;
    public const RULE_PASSWORD = 3;
    public const RULE_CHECKBOX = 4;

    /**
     * Validates multiple inputs. The hierachy is:
     * $inputs = [
     *      [
     *          "example@example.com", // value
     *          1 // rule (1 = RULE_MAIL)
     *              // min length
     *              // max length
     *              // chars
     *      ]
     * ]
     *
     * @param array $inputs
     * @return bool Returns true if all inputs are valid, otherwise return the first $input array, that is not valid.
     */
    public static function multipleValidate(array $inputs)
    {
        foreach ($inputs as $input) {
            if (!self::validate($input[0], $input[1], $input[2] ?? 0, $input[3] ?? 0, $input[4] ?? '/[^A-Za-z0-9]/')) {
                return $input;
            }
        }
        return true;
    }

    /**
     * Validates input by rule.
     * @param mixed $input The text(data) that will be validated.
     * @param int $rule Sets the rule for validating. If the rule is not valid, then it will use following parameters:
     * @param int|string $min_length The minimum length of $input. If $rule is 0 (RULE_CUSTOM), then pass Validator name
     * @param int $max_length The maximum length of $input.
     * @param string The character mask of $input. Regex.
     * @return bool Returns true if the input is valid, otherwise false.
     */
    public static function validate($input, int $rule = 0, $min_length_or_validator_name = 0, int $max_length = 0, string $chars = '/[^A-Za-z0-9]/'): bool
    {
        if (empty($input)) {
            return false;
        }
        switch ($rule) {
            case self::RULE_CUSTOM:
                if(!self::validatorExists((string)$min_length_or_validator_name)) return false;
                return self::$customValidators[$min_length_or_validator_name]::validate($input);
            case self::RULE_MAIL:
                return self::validateMail($input);
            case self::RULE_USERNAME:
                return self::validateUsername($input);
            case self::RULE_PASSWORD:
                return self::validatePassword($input);
            case self::RULE_CHECKBOX:
                return self::validateCheckBox($input);
            default:
                if (strlen($input) >= $min_length_or_validator_name && strlen($input) <= $max_length && !preg_match($chars, $input)) {
                    return true;
                } else {
                    return false;
                }

        }
    }

    /**
     * Validates $input as email.
     * @return bool Returns true if the $input is valid, false otherwise.
     */
    public static function validateMail(string $input): bool
    {
        if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    /**
     * Validates $input as username (only alphanumeric chars and minimum 4 chars length).
     * @return bool Returns true if the $input is valid, false otherwise.
     */
    public static function validateUsername(string $input): bool
    {
        if (!ctype_alnum($input) || strlen($input) < 4) {
            return false;
        }
        return true;
    }

    /**
     * Validates $input as password (minimum 6 chars length).
     * @return bool Returns true if the $input is valid, false otherwise.
     */
    public static function validatePassword(string $input): bool
    {
        if (strlen($input) < 6) {
            return false;
        }
        return true;
    }

    /**
     * Validates $input as checkbox (If equals to "on", returns true).
     * @return bool Returns true if the $input is valid, false otherwise.
     */
    public static function validateCheckBox(string $input): bool
    {
        if (strtolower($input) != "on") {
            return false;
        }
        return true;
    }

}
