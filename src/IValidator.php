<?php
/**
 * @name IValidator.php
 * @link https://alexkratky.cz                          Author website
 * @link https://panx.eu/docs/                          Documentation
 * @link https://github.com/AlexKratky/panx-framework/  Github Repository
 * @author Alex Kratky <info@alexkratky.cz>
 * @copyright Copyright (c) 2019 Alex Kratky
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @description Interface for Validator Function. Part of panx-framework.
 */

declare (strict_types = 1);

namespace AlexKratky;

interface IValidator {
    public static function validate($input): bool;
}
