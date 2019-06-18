<?php
use PHPUnit\Framework\TestCase;
use A3gZ\SimpleLocale\Locale;

class LocaleTest extends TestCase
{
  private function getSettings() {
    return @include __DIR__ . '/settings.php';
  }

  /**
   * @runInSeparateProcess
   */
  public function test_dates() {
    $locale = (new Locale($this->getSettings()))->withServices();
    $datetime = '2019-06-18 12:15:30';

    // Formatters used here come from the settings.php file
    $test = $locale->dates->format($datetime, 'timestamp');
    $this->assertSame($test, $datetime);

    $test = $locale->dates->format($datetime, 'short');
    $this->assertSame($test, '2019/06/18');

    $test = $locale->dates->format($datetime, 'long');
    $this->assertSame($test, 'Jun 18, 2019');

    $test = $locale->dates->format($datetime, 'longer');
    $this->assertSame($test, 'Jun 18, 2019 at 12:15:30');
  }

  /**
   * @runInSeparateProcess
   */
  public function test_currency() {
    $locale = (new Locale($this->getSettings()))->withServices();

    $test = $locale->currency->format(10.5);
    $this->assertSame($test, '$ 10.50');
  }

  /**
   * @runInSeparateProcess
   */
  public function test_dictionary() {
    $locale = (new Locale($this->getSettings()))->withServices();

    // Translate a text
    $test = $locale->dictionary->translate('hello world');
    $this->assertSame($test, 'Hola mundo!');

    // Translate a text with the handy wrapper
    $test = $locale->say('hello world');
    $this->assertSame($test, 'Hola mundo!');
  }

  /**
   * @runInSeparateProcess
   */
  public function test_number() {
    $locale = (new Locale($this->getSettings()))->withServices();

    $test = $locale->number->format(10.5);
    $this->assertSame($test, '10.50');
  }
}
