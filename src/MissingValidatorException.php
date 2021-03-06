<?php
/**
 * @name MissingValidatorException.php
 * @link https://alexkratky.com                         Author website
 * @link https://panx.eu/docs/                          Documentation
 * @link https://github.com/AlexKratky/ValidatorX/      Github Repository
 * @author Alex Kratky <alex@panx.dev>
 * @copyright Copyright (c) 2020 Alex Kratky
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @description Missing Validator Exception. Part of panx-framework.
 */

namespace AlexKratky;

class MissingValidatorException extends \Exception
{
    public function __construct($validator) {
        parent::__construct("Missing Validator rule '{$validator}'", 0, null);
    }

    public function __toString() {
        return __CLASS__ . ": {$this->message}\n";
    }
}