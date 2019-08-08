<?php
/**
 * @link      https://github.com/a3gz/simple-locale
 * @copyright Copyright (c) Alejandro Arbiza
 * @license   See included file LICENSE.md
 */
namespace A3gZ\SimpleLocale;

class Locale
{
  protected $regionCode = null;
  protected $services = [];
  protected $settings = null;

  public function __construct($settings) {
    if ( !isset($settings['languages']) || !count($settings['languages']) ) {
      throw new \Exception("Invalid settings: [languages] array is missing or empty.");
    }
    $this->settings = $settings;
    $this->regionCode = $settings['languages'][0];
  }

  public function __get($key) {
    return (isset($this->services[$key]) ? $this->services[$key] : null);
  }

  public function getRegionCode() {
    return $this->regionCode;
  }

  public function parseLocalizedRequest($request) {
    $uri = $request->getUri();
    $path = $uri->getPath();
    $matches = [];
    if ( preg_match( "#^(" . implode('|', $codes) . ")\/#", $path, $matches ) ) {
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

  public function withRegionCode($regionCode) {
    $clone = clone $this;
    $clone->regionCode = $regionCode;
    return $clone;
  }

  public function withServices($regionCode = null) {
    $clone = clone $this;

    $settings = $this->settings;
    if (!$regionCode) {
      $regionCode = $this->regionCode;
    }
    if (function_exists('setlocale')) {
      $setlocale = $regionCode . '_' . strtoupper($regionCode);
      if (isset($settings['env'][$regionCode]['setlocale'])) {
        $setlocale = $settings['env'][$regionCode]['setlocale'];
      }
      setlocale(LC_ALL, $setlocale);
    }
    $clone->services = [
      'currency' => new \A3gZ\SimpleLocale\Services\Currency($settings, $regionCode),
      'dates' => new \A3gZ\SimpleLocale\Services\Dates($settings, $regionCode),
      'dictionary' => new \A3gZ\SimpleLocale\Services\Dictionary($settings, $regionCode),
      'number' => new \A3gZ\SimpleLocale\Services\Number($settings, $regionCode),
    ];
    return $clone;
  }
} // class

// EOF
