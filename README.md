# QueryHandler

this class's method are static .... that mean you don't need to create an object to use it .
All methodes will return an Exception if it faild .

<h2 style="background-color:#333;color:#fff">Open - Close the Connection</h2>
To connect to database use  openConnection($Host , $DBName , $DBUserName , $DBUserPassword) 
where :
$Host :is your host (localhost  or your server IP).
$DBName : is your database name that you want to connect it.
$DBUserName : is your username that can connect to selected DB.
$DBUserPassword : is the user 's password .

 Dont't forget to close connection before connection to an other database and don't forget to open connection before calling any query method
 To close Connection use closeConnection() .
 
----------------------------------------

<h2 style="background-color:#333;color:#fff">CRUD Methods</h2>

All CRUD Methods could be used fo Any table that you want .

<h3 style="background-color:#333;color:#fff">Insert Methods</h3>

1- insertIntoableByValues($table ,   $ColumnsAndValuesArray) 
where :
$table is your table name and $ColumnsAndValuesArray is the Post array (or any associative array) .
(( don't forget to open connection before calling any query method )) .

2- insertIntoableByqueryStatment($statment , $valuesArrayForAlias = array()) 
where :
$statment is the query that you want to execute it 
Note : query wil be prepared by prepare PDO method ...... for values use ? and pass the values in $valuesArrayForAlias .


<h3 style="background-color:#333;color:#fff">remove  Methods</h3>

1 - removeItemById($table , $id) 
where :
$table is the table name and $id is Item id that you want to remove it .

2- removeItemByDeleteStatment($statment , $valuesArrayForAlias = array()) 
where :
$statment is the query that you want to execute it 
Note : query wil be prepared by prepare PDO method ...... for values use ? and pass the values in $valuesArrayForAlias .


<h3 style="background-color:#333;color:#fff">Find (get Item Informations)  Methodes</h3>

1 - getItemAllInfoById($table , $id)
where :
$table is the table name and $id is Item id that you want to get it's information .
//Note : by this method you can only get one row information ...... to get more than use getItems methods

2 - getItemSomeInfoById($table , $arrayOfColumns, $id)
where :
$table is the table name and $id is Item id that you want to get it's information .
and $arrayOfColumns is a indexed array of columns that you want it's values .
//Note : by this method you can only get one row's some informations ...... to get more than use getItems methods

3 - getItemInfoBySelectStatement($statment , $valuesArrayForAlias = array())
where :
$statment is the query that you want to execute it 
Note : query wil be prepared by prepare PDO method ...... for values use ? and pass the values in $valuesArrayForAlias .
//Note : by this method you can only get one row information ...... to get more than use getItems methods


4 - getItemsSomeInfo($table , $arrayOfColumns)
where :
$table is the table name  , and $arrayOfColumns is a indexed array of columns that you want it's values .
this method return multi rows in indexed array of objects.

5 - getItemsInfoBySelectStatement($statment , $valuesArrayForAlias = array())
where :
$statment is the query that you want to execute it 
Note : query wil be prepared by prepare PDO method ...... for values use ? and pass the values in $valuesArrayForAlias .
this method return multi rows in indexed array of objects.

<h3 style="background-color:#333;color:#fff">update  Methods</h3>

1 - updateByqueryStatment($statment , $valuesArrayForAlias = array())
where :
$statment is the query that you want to execute it 
Note : query wil be prepared by prepare PDO method ...... for values use ? and pass the values in $valuesArrayForAlias .
this method is used to update row or multi row (as you like) by the statment that you write

<h3 style="background-color:#333;color:#fff">is item Unique or found Metohds</h3>

1 - isItemFoundQueryByValuesAndOperators($table , $arrayOfColumnsAndValues , $OperatorsArrayBetweenColumnValues)
where :
$table is the table name
$arrayOfColumnsAndValues is associative array (key is column name , value is column's value)
$OperatorsArrayBetweenColumnValues is an indexed array of operators that you want to put between column and their values
(it can take one operator for all columns but if the operators more than one you must write qn equal write of columns   
that mean : 
one operator 
or
(count(OperatorsArrayBetweenColumnValues) == count(arrayOfColumnsAndValues)) must be true  .
ex : 
QueryHandler::isItemFoundQueryByValuesAndOperators("users" , array("name" => "Muhammed" , "phoneNumber" => "0999999999") , array("="));
or
QueryHandler::isItemFoundQueryByValuesAndOperators("users" , array("name" => "Muhammed" , "phoneNumber" => "0999999999") , array("=" , ">="));

Don't Forget to support me on :
<p dir="rtl" >لا تنسى دعمي على </p>
<p>Facebook : https://www.facebook.com/MDRDevelopment/</p>
<p>Facebook : https://www.instagram.com/mdr_development_tr/</p>

