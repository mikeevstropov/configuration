# mikeevstropov/configuration

Read and write configuration parameters to the YAML file.

## Install

Add dependency by [Composer](http://getcomposer.org)

```bash
$ composer require mikeevstropov/configuration
```

## Example usage

As example we have following configuration file.

```yaml
# app/config/config.yml
  
my_parameter: my_value
```

What we can do with it?

```php
<?php
  
namespace Mikeevstropov\Configuration\Configuration;
  
// origin configuration
$originFile = 'app/config/config.yml';
  
// modified configuration
$modifiedFile = 'var/temp/config.yml';
  
// create instance
$configuration = new Configuration(
    $originFile,
    $modifiedFile
);
  
// get parameter
$value = $configuration->get('my_parameter'); // my_value
  
// set parameter
// and save it to the file of modified configuration
$configuration->set('my_parameter', 'new_value');
  
// check it
$configuration->get('my_parameter'); // new_value
  
// now we can remove instance or exit form runtime
unset($configuration);
  
// create instance again
$configuration = new Configuration(
    $originFile,
    $modifiedFile
);
  
// and check saved value
$value = $configuration->get('my_parameter'); // new_value
  
// it has
$configuration->has('my_parameter'); // true
  
// remove
$configuration->remove('my_parameter');
  
// not defined
$configuration->has('my_parameter'); // false
  
// also you can use "strict getter" to get existed value
// or throw InvalidArgumentException if not
$configuration->getStrict('my_parameter'); // thrown InvalidArgumentException

```

As you can see, when we are using setter the value will saved
to the file of modified configuration and loaded next time ass
well.

## Development

Clone

```bash
$ git clone https://github.com/mikeevstropov/configuration.git
```

Go to project

```bash
$ cd configuration
```

Install dependencies

```bash
$ composer install
```

Set the permissions

```bash
$ sudo chmod 777 ./var -v -R
```

Try to test ([PHPUnit](https://phpunit.de/) is required in global scope)

```bash
$ composer test
```