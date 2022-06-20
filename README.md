# snowflake 
![Packagist Version](https://img.shields.io/packagist/v/hyqo/snowflake?style=flat-square)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/hyqo/snowflake?style=flat-square)
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/hyqo/snowflake/run-tests?style=flat-square)

## Install

```sh
composer require hyqo/snowflake
```

## Usage
```php
$snowflake = new \Hyqo\Snowflake\Snowflake();
$snowflake->generate(); 
// 176648695220225

$snowflake->parse('176648695220225'); 
// ["timestamp"]=> 
// int(172508491426)
// ["sequence"]=>
// int(1)
```
