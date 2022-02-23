# ThePay 2.0
This is small Nette Framework wrapper for ThePay 2.0 payment gateway.

## Installation
The easiest way to install library is via Composer.

````sh
$ composer require lzaplata/thepay: dev-master
````
or edit `composer.json` in your project

````json
"require": {
        "lzaplata/thepay": "dev-master"
}
````

You have to register the library as extension in `config.neon` file.

````neon
extensions:
        thepay: LZaplata\ThePay\DI\Extension
````

Now you can set parameters...

````neon
thepay:
        demo            : true|false
        merchantId      : *
        projectId       : *
        apiPassword     : *
````

...and autowire library to presenter

````php
use LZaplata\ThePay\Service;

/** @var Service @inject */
public $thepay;
````
## Usage
Create payment parameters, set return or notify URL just like in original API client example.

https://packagist.org/packages/thepay/api-client

````php
$paymentParams = new CreatePaymentParams($amount, $currencyCode, $uid);
$paymentParams->setReturnUrl("some return URL");
````

Create payment.

````php
$payment = $this->thepay->createPayment($paymentParams);
````

Redirect to payment gateway.

````php
$this->sendResponse(new RedirectResponse($payment->getPayUrl()));
````
