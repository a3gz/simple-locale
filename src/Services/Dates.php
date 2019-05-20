<?php
/**
 * @link      https://github.com/a3gz/simple-locale
 * @copyright Copyright (c) Alejandro Arbiza
 * @license   http://www.roetal.com/license/mit (MIT License)
 */
namespace A3gZ\SimpleLocale\Services;

class Dates extends AbstractService
{
  public function format( $time, $format = false ) {
    if (!$format) {
      $format = 'Y/m/d';
    }

    $formatted = false;

    if (is_numeric($time)) {
      if (isset($this->env->$format)) {
        $formatted = date($this->env->$format, $time);
      } elseif (is_string($format)) {
        $formatted = date($format, $time);
      }
    }

    return $formatted;
  }

  public function today($format = false) {
    return $this->format(time(), $format);
  }
}

// EOF
