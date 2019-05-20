<?php
/**
 * @link      https://github.com/a3gz/simple-locale
 * @copyright Copyright (c) Alejandro Arbiza
 * @license   http://www.roetal.com/license/mit (MIT License)
 */
namespace A3gZ\SimpleLocale;

class Locale
{
  protected $regionCode = null;
  protected $services = [];
  protected $settings = null;

  public function __construct($settings) {
    if (!isset($settings['languages']) || !count($settings['languages'])) {
      throw new \Exception("Invalid settings: [languages] array is missing or empty.");
    }
    $regionCode = $settings['languages'][0];
    $this->settings = $settings;
    $this->regionCode = $regionCode;
    $this->services = $this->buildServices($settings, $regionCode);
  }

  public function __get($key) {
    return (isset($this->services[$key]) ? $this->services[$key] : null);
  }

  protected function buildServices($settings, $regionCode) {
    return [
      'currency' => new Services\Currency($settings, $regionCode),
      'dates' => new Services\Dates($settings, $regionCode),
      'dictionary' => new Services\Dictionary($settings, $regionCode),
      'number' => new Services\Number($settings, $regionCode),
    ];
  }

  public function parseLocalizedRequest($request) {
    $uri = $request->getUri();
    $path = $uri->getPath();
    $matches = [];
    if (preg_match( "#^(" . implode('|', $codes) . ")\/#", $path, $matches )) {
      $this->regionCode = $matches[1];
      $newPath = substr( $path, strlen($matches[0]) );
      $uri = $uri->withPath( $newPath );
      $request = $request->withUri( $uri, true );
    }
    return $request;
  }

  public function say($t) {
    if (!$this->services || !$this->services['dictionary']) {
      return $t;
    }
    return call_user_func_array([$this->services['dictionary'], 'translate'], func_get_args() );
  }

  public function withServices($regionCode = null) {
    $clone = clone $this;

    $settings = $this->settings;
    if (!$regionCode) {
      $regionCode = $this->regionCode;
    }
    $clone->services = $this->buildServices($settings, $regionCode);
    return $clone;
  }
} // class

// EOF
