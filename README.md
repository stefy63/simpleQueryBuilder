# simpleQueryBuilder is a simple Query Builder for PHP
Is a fork of [davidecesarano/embryo-pdo]  (https://github.com/davidecesarano/Embryo-PDO)


## simpleQueryBuilder
A quick and light PHP query builder using PDO.
```php
$users = $pdo->table('users')
    ->where('country', 'Italy')
    ->and('city', 'Naples')
    ->and(function($query) {
        $query
            ->where('age', 20)
            ->or('age', 30)
    })
    ->andIsNotNull('updated_at')
    ->andIn('roles', [1, 2, 3])
    ->get();
```

## Requirements
* PHP >= 7.1

## Installation
Using Composer:
```
$ composer require stefy63/simpleQueryBuilder
```

### Connection

Create a multidimensional array with database parameters and pass it at the `Database` object. Later, create connection with `connection` method. 
```php
$database = [
    'local' => [
        'engine'   => 'mysql',
        'host'     => '127.0.0.1',
        'name'     => 'db_name',
        'user'     => 'user',  
        'password' => 'password',
        'charset'  => 'utf8mb4',
        'options'  => [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ]
    ]
];

$database = new Embryo\PDO\Database($database);
$pdo = $database->connection('local');
```

