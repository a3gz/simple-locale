<?php
/**
 * @link      https://github.com/a3gz/simple-locale
 * @copyright Copyright (c) Alejandro Arbiza
 * @license   http://www.roetal.com/license/mit (MIT License)
 */
namespace A3gZ\SimpleLocale\Services;

class Currency extends Number
{
  public function format($number) {
    $formatted = parent::format($number);
    return "{$this->env->symbolBefore}{$formatted}{$this->env->symbolAfter}";
  }
}

// EOF
