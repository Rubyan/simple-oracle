<b>Connect with CakePHP 3 to Oracle</b>

Example usage:

composer require rubyan/simple-oracle:dev-master

```php
    $config['host'] = 'localhost';
    $config['username'] = 'demo';
    $config['password'] = 'demo';
    $config['port'] = 1521;
    $config['instance_name'] = 'xe';
    $config['charset'] = 'UTF8';

    $db = new Oracle($config);   
    $sql = 'SELECT * FROM HR.JOBS';
    $db->execute($sql);
```