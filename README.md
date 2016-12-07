# IBAN

[![Build Status][badge-build]][build]
[![Scrutinizer][badge-quality]][quality]
[![Software License][badge-license]][license]
[![Total Downloads][badge-downloads]][downloads]

cmpayments/iban is a PHP 5.5+ library for validating IBAN bank account numbers.

It currently supports IBAN validation of 99 countries

## Installation

To install cmpayments/iban just require it with composer
```
composer require cmpayments/iban
```

## Usage example

```php
<?php
require 'vendor/autoload.php';

use CMPayments\IBAN;

$iban = new IBAN('NL58ABNA0000000001');

// validate the IBAN
if (!$iban->validate($error)) {
    echo "IBAN is not valid, error: " . $error;
}

// pretty print IBAN
echo $iban->format();
```

## Submitting bugs and feature requests

Bugs and feature request are tracked on [GitHub](https://github.com/cmpayments/iban/issues)

## Copyright and license

The cmpayment/iban library is copyright © [Bas Peters](https://github.com/baspeters/) and licensed for use under the MIT License (MIT). Please see [LICENSE][] for more information.

[badge-build]: https://img.shields.io/travis/cmpayments/iban.svg?style=flat-square
[badge-quality]: https://img.shields.io/scrutinizer/g/cmpayments/iban.svg?style=flat-square
[badge-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[badge-downloads]: https://img.shields.io/packagist/dt/cmpayments/iban.svg?style=flat-square

[license]: https://github.com/cmpayments/iban/blob/master/LICENSE
[build]: https://travis-ci.org/cmpayments/iban
[quality]: https://scrutinizer-ci.com/g/cmpayments/iban/
[coverage]: https://coveralls.io/r/cmpayments/iban?branch=master
[downloads]: https://packagist.org/packages/cmpayments/iban