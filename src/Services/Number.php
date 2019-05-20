<?php
/**
 * @link      https://github.com/a3gz/simple-locale
 * @copyright Copyright (c) Alejandro Arbiza
 * @license   http://www.roetal.com/license/mit (MIT License)
 */
namespace A3gZ\SimpleLocale\Services;

class Number extends AbstractService
{
  public function format($number) {
    return number_format(
      $number,
      $this->env->decimals,
      $this->env->decimalPoint,
      $this->env->thousandsSeparator
    );
  }
}

// EOF
