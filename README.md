# SDK for Order-Track v4 API

[![Tests](https://img.shields.io/github/actions/workflow/status/pdf-systems-inc/order-track-sdk/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/pdf-systems-inc/order-track-sdk/actions/workflows/run-tests.yml)

This is where your description should go. Try and limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer, but first you need to add PDF's composer repository to your composer.json file:

```json
{
    "repositories": [
        {
            "type": "composer",
            "url": "https://satis.pdfsystems.com"
        }
    ]
}
```

Then you can install the package:

```bash
composer require pdf-systems-inc/order-track-sdk
```

## Usage

### Creating a Client

```php
$client = new Pdfsystems\OrderTrackSdk\OrderTrackClient('{Auth Token}', '{Team ID}');
```

### Customers

#### Searching for Customers
```php
$client->customers()->search(params: [
    'customer_number' => '123456',
    'name' => 'John Doe',    
]);
````
#### Loading a Specific Customer
```php
$client->customers()->findByCustomerNumber('123456');
```

### Products

#### Searching for Products
```php
$client->products()->search(params: [
    'item_number' => '1000-01',
    'style_name' => 'Kensington',
    'color_name' => 'Red',
    'discontinued' => 'false',    
]);
```
#### Loading a Specific Product
```php
$client->products()->findByItemNumber('1000-01');
```

### Orders

#### Searching for Orders
```php
$client->orders()->search(params: [
    'customer' => 123456,
    'customer_number' => 'A1234',
    'start_date' => '2023-01-01',
    'end_date' => '2023-12-31',    
]);
```
#### Loading a Specific Order
```php
$client->orders()->findByOrderNumber('100000-0');
```

### Sample Orders

#### Searching for Sample Orders
```php
$client->sampleOrders()->search(params: [
    'shippable_items' => ['1000-01', '1000-02'],
    'start_date' => '2023-01-01',
    'end_date' => '2023-12-31',    
]);
```

#### Creating a Sample Order
```php
$sampleOrder = new Pdfsystems\OrderTrackSdk\Dtos\SampleOrder([
    'customer_id' => 1,
    'items' => [
        [
            'item_number' => '1000-01',
            'quantity_ordered' => 1,
        ],    
    ],
    'sample_usage_type_id' => 1,
    'sample_order_source_id' => 1,
]);
$client->sampleOrders()->create($sampleOrder);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Rob Pungello](https://github.com/rpungello)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
