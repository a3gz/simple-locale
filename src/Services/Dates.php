<?php
/**
 * @link      https://github.com/a3gz/simple-locale
 * @copyright Copyright (c) Alejandro Arbiza
 * @license   See included file LICENSE.md
 */
namespace A3gZ\SimpleLocale\Services;

class Dates extends AbstractService
{
  public function format($time, $format = false) {
    if (!$format) {
      $format = 'Y/m/d';
    }

    $formatted = false;

    if (!is_numeric($time)) {
      $time = strtotime($time);
    }

    if (isset($this->env->$format)) {
      $format = $this->env->$format;
    }

    if (is_string($format)) {
      if (strpos($format, '%') !== false) {
        $formatted = strftime($format, $time);
      } else {
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
