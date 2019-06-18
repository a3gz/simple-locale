# Simple Locale

## Install

    composer require a3gz/simple-locale

## Setup
Create an associative array with the settings having:

1. `languages`: An array of language codes. The codes used here are completely arbitrary.
2. `env`: Several environment settings for each language so the localizer knows how to format things like currency and dates.
3. `dictionaries`: Here we provide the dictionary files where string keys are associated to translations.

A typical settings array would look like this

    $settings = [
      'languages' => ['en'],
      'env' => [
        'en' => [
          /* Numbers */
          'decimals' => 2,
          'decimalPoint' => '.',
          'thousandsSeparator' => ' ',
          /* Currency */
          'symbolBefore' => '$ ',
          'symbolAfter' => '',
          /* Dates */
          'timestamp' => 'Y-m-d H:i:s',
          'short' => 'Y/m/d',
          'long' => 'M j, Y',
          'longer' => 'M j, Y \a\t H:i:s',
        ],
        'fr' => false,
        'es' => false,
      ],
      'dictionaries' => [
        function($languageCode) {
          $base = dirname(__DIR__) . '/domain/locale';
          $dn = "{$base}/{$languageCode}/dictionary.php";
          if (is_readable($dn)) {
            return @include($dn);
          }
        },
      ],
    ];

### About dictionaries
A dictionary is a PHP file that returns an associative array having string keys and translations as shown below:

    return [
      'hello world' => 'Hola mundo!',
    ];

An application may have one or more dictionaries and this is why the `dictionaries` section is expected to be an array. The demo above shows the simplest form where all translations are located in one file.

Although it isn't required, it is suggested that dictionaries are located inside a directory named as the corresponding language code defined under the `languages` section. Note the part where the full path to the dictionary file is built:

    $dn = "{$base}/{$code}/dictionary.php";


## Usage

    $locale = new Locale($settings);

    echo $locale->dictionary->say('hello world');
    echo $locale->currency->format12.50);
