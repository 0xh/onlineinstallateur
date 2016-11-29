# Extra Order Data

This module add extra informations on the customer when an order is placed.
For now, just the IP and the User agent is saved and linked to the order.

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is ExtraOrdrData.
* Activate it in your thelia administration panel

### Composer

Add it in your main thelia composer.json file

```
composer require your-vendor/extra-order-data-module:~1.0
```

## Usage

In the back office, in the modules tab of the order page, you have the IP and the User Agent of the 
customer, when he placed his order.