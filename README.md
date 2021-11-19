# Teamwork Provider for OAuth 2.0 Client

This package provides a Teamwork OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Installation

To install, use composer:

```
composer require iqnection-programming/teamwork-oauth2
```

## Usage
View examples in the [example](https://github.com/iqnection-programming/teamwork-oauth2/tree/master/example) directory

### Authorization Code Flow

```php
$provider = new \IQnectionProgramming\TeamworkOAuth2\Provider\Teamwork([
	'clientId'          => 'my-client-id',
	'clientSecret'      => 'my-client-secret',
	'redirectUri'       => 'https://example.com/my-redirect-uri'
]);
```
For further usage of this package please refer to the [core package documentation on "Authorization Code Grant"](https://github.com/thephpleague/oauth2-client#usage).

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## License

The MIT License (MIT). Please see [License File](https://github.com/iqnection-programming/teamwork-oauth2/blob/master/LICENSE.md) for more information.
