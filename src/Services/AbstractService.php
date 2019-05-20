<?php
/**
 * @link      https://github.com/a3gz/simple-locale
 * @copyright Copyright (c) Alejandro Arbiza
 * @license   http://www.roetal.com/license/mit (MIT License)
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
      foreach ($settings['dictionaries'] as $name => $f) {
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
}

// EOF
