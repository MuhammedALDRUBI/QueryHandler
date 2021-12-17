# QueryHandler
a short-handed way to perform CRUD statments, with an Exception handling embeded.

## How to use 
- basically ,you won't need anything but importing the file as bellow.
- please note that none of the methods provided is non-static, so make sure to call any method statically. 

```php 
<?php 
require 'QueryHandler.php';

QueryHandler::methodName($params)
>
```

## methods 

> it's important that you make a db connection using the connect method listed bellow before any othere query.

### connect 
open a connection with database
```php 
QueryHandler::connect('[hostname]' ,'[database_Name]' ,'[database_username]' ,'[database_password]')
```
### close 
close a connection with database 
```php 
QueryHandler::close()
```
### create 
insert a record in a target table 
```php 
QueryHandler::create('tasks' ,[
    'task_name' => 'example name',
])
```

### read 
select a specific row in a target table 
```php 
QueryHandler::read('tasks' ,'[row_id]')
```

### readSome
select a specific row's columns in a target table 
```php 
QueryHandler::readSome('tasks' ,$array_of_wanted_fields ,'[row_id]')
```

### readAll
select a specific table's rows
```php 
QueryHandler::readAll('tasks' ,$array_of_wanted_fields)
```

### delete 
remove a specific row in a target table 
```php 
QueryHandler::delete('tasks' ,'[row_id]')
```

### customSQL
perform a custom SQL query 
```php 
QueryHandler::customSQL('[your_custom_query_here]')
```

### isItemFoundQueryByValuesAndOperators
isItemFoundQueryByValuesAndOperators($table , $arrayOfColumnsAndValues , $OperatorsArrayBetweenColumnValues)
where :
$table is the table name
$arrayOfColumnsAndValues is associative array (key is column name , value is column's value)
$OperatorsArrayBetweenColumnValues is an indexed array of operators that you want to put between column and their values
(it can take one operator for all columns but if the operators more than one you must write qn equal write of columns   
that mean : 
one operator 
or
```php 
(count(OperatorsArrayBetweenColumnValues) == count(arrayOfColumnsAndValues)) must be true  .
```
ex 
```php 
QueryHandler::isItemFoundQueryByValuesAndOperators("users" , [
    "name" => "Muhammed" , 
    "phoneNumber" => "0999999999"
    ] , ["="]
);
```

or
```php 
QueryHandler::isItemFoundQueryByValuesAndOperators("users" , [
    "name" => "Muhammed" , 
    "phoneNumber" => "0999999999"
    ] , 
    [ "=" ,  ">=" ]
);
```

## maintainers
* [MuhammedALDRUBI](https://github.com/MuhammedALDRUBI)
* [Adnane](https://github.com/adnane-ka) 


## Support 
Don't Forget to support me on :

* [Facebook](https://www.facebook.com/MDRDevelopment/)
* [Instagram](https://www.instagram.com/mdr_development_tr/)

