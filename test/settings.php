<?php
return [
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
  ],
  'dictionaries' => [
    function($languageCode) {
      $base = __DIR__;
      $dn = "{$base}/{$languageCode}/dictionary.php";
      if (is_readable($dn)) {
        return @include($dn);
      }
    },
  ],
];

// EOF