<?php
/**
 * @link      https://github.com/a3gz/simple-locale
 * @copyright Copyright (c) Alejandro Arbiza
 * @license   See included file LICENSE.md
 */
namespace A3gZ\SimpleLocale\Services;

abstract class AbstractService
{
  protected $env;
  protected $dictionary = [];

  public function __construct($settings, $regionCode) {
    if (!isset($settings['env']) || !isset($settings['env'][$regionCode])) {
      throw new \Exception("Invalid locale settings: [env][{$regionCode}] is missing.");
    }
    $this->env = (object)$settings['env'][$regionCode];

    if (isset($settings['dictionaries'])) {
      foreach ($settings['dictionaries'] as $f) {
        try {
          $d = $f($regionCode);
          if (is_array($d)) {
            $this->dictionary = array_merge($this->dictionary, $d);
          }
        } catch(\Exception $e) {
          // Ignore the faulty dictionary
        }
      }
    }
    return $this;
  }

  public function withEnv($key, $value) {
    $clone = clone $this;
    $clone->env->$key = $value;
    return $clone;
  }
}

// EOF
