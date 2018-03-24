(1)DATABASE ()
-------------------
config/db.php             contains application configurations
```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
```

(2)INSTALLATION
------------
```
composer install
```

(3)Database Migration
------------
```
php yii migrate
```