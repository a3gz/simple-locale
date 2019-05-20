<?php
/**
 * @link      https://github.com/a3gz/simple-locale
 * @copyright Copyright (c) Alejandro Arbiza
 * @license   http://www.roetal.com/license/mit (MIT License)
 */
namespace A3gZ\SimpleLocale\Services;

class Dictionary extends AbstractService
{
  public function translate() {
    $args = func_get_args();
    if (!isset($this->dictionary[$args[0]])) {
      return $args[0];
    }

    if (count($args) > 1) {
        $key = array_shift($args);
        $args = array_merge([ $this->dictionary[$key] ], $args);
        return call_user_func_array('sprintf', $args);
    }

    $key = $args[0];
    return $this->dictionary[$key];
  }
}

// EOF
