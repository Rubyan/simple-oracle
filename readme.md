# Connect with CakePHP 3 to Oracle

This is a very lightweight solution to connect to an Oracle Database using OCI8.

## Installing via composer:

composer require rubyan/simple-oracle:dev-master

## Example usage in CakePHP 3

```php

    $config['host'] = 'localhost';
    $config['username'] = 'demo';
    $config['password'] = 'demo';
    $config['port'] = 1521;
    $config['instance_name'] = 'xe';
    $config['charset'] = 'UTF8';

    $db = new \Rubyan\Oracle\Oracle($config);   
    $sql = 'SELECT * FROM HR.JOBS';
    $db->execute($sql);
```