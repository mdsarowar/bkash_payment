# bKash Integration Package for Laravel
 This package simplifies the integration of the bKash payment gateway into Laravel applications, supporting tokenized payments for a secure and seamless transaction experience.

## Features

- Generate bKash Token
- Create Payments
- Execute Payments
- Query Payment Status

## Installation
1. Install the package via Composer:
   ```bash
   composer require sarowar/bkash


Create Payment

$data = [
'amount' => '1000',
'currency' => 'BDT',
'intent' => 'sale',
];
$response = $bkash->create_payment($data);


# License
This package is open-sourced software licensed under the MIT license.
