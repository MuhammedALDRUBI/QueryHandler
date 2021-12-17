<?php

class QueryHandler{

    /**
     * instance of PDO Object representing a connection object
    */
    static private  $connectionObject = null;
  
    /**
     * open a connection with database 
     * it's important that you close the current connection before connecting to other DB
     * 
     * @param $Host (representing the hostname ex localhost)
     * @param $DBName (database name)
     * @param $DBUserName (database user name)
     * @param $DBUserPassword (database user password)
     * 
     * @return instance of PDO 
    */
    static public function connect($Host , $DBName , $DBUserName , $DBUserPassword){
        try{
            $dns = "mysql:host=" . $Host . ";dbname=" . $DBName .";charset=utf8";
            self::$connectionObject = new PDO($dns , $DBUserName , $DBUserPassword);
            self::$connectionObject->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return self::$connectionObject;
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * close a connection with database 
     * 
     * @return boolean
    */
    static public function close(){
        self::$connectionObject = null;
        return true;
    }

    /**
     * insert a record in a target table 
     * 
     * @param $table (target table)
     * @param $ColumnsAndValuesArray (associative array,in which each key-column- is attached to a given value)
     * 
     * @return boolean 
    */
    static public function create($table , $ColumnsAndValuesArray){
        
        try{
            if(self::$connectionObject == null){
                throw new Exception("You must open the connection with database first !");
            }
            $query = "insert into " . $table  . " ";
            $query_columns = "( ";
            $query_values = "Values( ";
            $keys_array = array_keys($ColumnsAndValuesArray);
            $valuesArray_after_editing = array();
            $countOfValues = count($ColumnsAndValuesArray);
            
            for($i=0;$i<$countOfValues;$i++){
                if($i == $countOfValues - 1){
                    $query_columns .= $keys_array[$i] ;
                    $query_values .= " ? ";
                }else{
                    $query_columns .= $keys_array[$i] . " , ";
                    $query_values .= " ?  , ";
                }
                $valuesArray_after_editing[] = $ColumnsAndValuesArray[$keys_array[$i]];
            }
            
            $query_columns .= " )";
            $query_values .= " )";
            $query .= $query_columns . " " . $query_values . " ;";
            $insertQuery = self::$connectionObject->prepare($query);
            $resultOfInserting = $insertQuery->execute($valuesArray_after_editing);
            return $resultOfInserting;
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * select a specific row in a target table 
     * 
     * @param $table (target table)
     * @param $id (target row's id)
     * 
     * @return array 
    */
    static public function read($table , $id){
        try{
            if(self::$connectionObject == null){
                throw new Exception("You must open the connection with database first !");
            }
            $getInfo_query_string = "select * from " . $table . " where Id = ? limit 1";
            $getInfo_query = self::$connectionObject->prepare($getInfo_query_string);
            $getInfo_query->execute(array($id));
            $row_info = $getInfo_query->fetch();
            return $row_info;
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * select a specific row's columns in a target table 
     * 
     * @param string $table (target table)
     * @param array $arrayOfColumns (indexed array containing wanted columns)
     * @param int $id (target row's id)
     * 
     * @return array 
    */
    static public function readSome($table , $arrayOfColumns, $id){
        try{
            if(self::$connectionObject == null){
                throw new Exception("You must open the connection with database first !");
            }
            $countOfColumns = count($arrayOfColumns);
            $getInfo_query_string = "select " ;
            for($i=0;$i<$countOfColumns;$i++){
                if($i == $countOfColumns - 1){
                    $getInfo_query_string .= $arrayOfColumns[$i];
                }else{
                    $getInfo_query_string .= $arrayOfColumns[$i] . " , ";
                }
            }
            $getInfo_query_string .= " from " . $table . " where Id = ? limit 1";

            $getInfo_query = self::$connectionObject->prepare($getInfo_query_string);
            $getInfo_query->execute(array($id));
            $row_info = $getInfo_query->fetch();
            return $row_info;
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * select a specific table's rows
     * 
     * @param string $table (target table)
     * @param array $arrayOfColumns (indexed array containing wanted columns)
     * 
     * @return array 
    */
    static public function readAll($table , $arrayOfColumns){
        try{
            if(self::$connectionObject == null){
                throw new Exception("You must open the connection with database first !");
            }
            $countOfColumns = count($arrayOfColumns);
            $getInfo_query_string = "select " ;
            for($i=0;$i<$countOfColumns;$i++){
                if($i == $countOfColumns - 1){
                    $getInfo_query_string .= $arrayOfColumns[$i];
                }else{
                    $getInfo_query_string .= $arrayOfColumns[$i] . " , ";
                }
            }
            $getInfo_query_string .= " from " . $table . " ;";

            $getInfo_query = self::$connectionObject->prepare($getInfo_query_string);
            $getInfo_query->execute();
            $rows_info = $getInfo_query->fetchAll();
            return $rows_info;
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    } 

    /**
     * remove a specific row in a target table 
     * 
     * @param $table (target table)
     * @param $id (target row's id)
     * 
     * @return boolean 
    */
    static public function delete($table , $id){
        try{
            if(self::$connectionObject == null){
                throw new Exception("You must open the connection with database first !");
            }
            $delete_query_string =  "delete from " . $table . " where Id = ?";
            $delete_query = self::$connectionObject->prepare($delete_query_string);
            $resultOfDeleting = $delete_query->execute(array($id));
            return $resultOfDeleting;
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }
  
    /**
     * perform a custom SQL query 
     * 
     * @param string $statment
     * @param array $valuesArrayForAlias
    */
    public static function customSQL($statment ,$valuesArrayForAlias = [])
    {
        try{
            if(self::$connectionObject == null){
                throw new Exception("You must open the connection with database first !");
            }

            # boolean result will be  returned in insert/update/delete statments
            $query = self::$connectionObject->prepare($statment); 
            $result = $query->execute($valuesArrayForAlias);

            # for custom select statments , $result->fetch() & $result->fetchAll can be used directly 
            return $result;
        }
        catch(Exception $e){
            return $e->getMessage();
        }

    }

    /*
    ===============================================================================
    ================================================is item Unique or found Metohds
    ===============================================================================
    */
    static public function isItemFoundQueryByValuesAndOperators($table , $arrayOfColumnsAndValues , $OperatorsArrayBetweenColumnValues){

        try{
            if(self::$connectionObject == null){
                throw new Exception("You must open the connection with database first !");
            }
            $valuesArray_after_editing = array();
            $statement = "select count(Id) as count from " . $table . " where " ; 
            $i = 0;
            $countOfValues = count($arrayOfColumnsAndValues);
            $countOfOperators = count($OperatorsArrayBetweenColumnValues);
            foreach($arrayOfColumnsAndValues as $key => $val){
                $statement .= " " . $key . " ";
                $statement .=  $countOfOperators > 1 ? $OperatorsArrayBetweenColumnValues[$i] :  $OperatorsArrayBetweenColumnValues[0];
                $statement .= $i == $countOfValues - 1 ?   "  ? " :  " ?  and ";
                $valuesArray_after_editing[$i] = $val;
                $i++;
            }
            
            $matched_items = self::getItemInfoBySelectStatement($statement , $valuesArray_after_editing)["count"];
            return $matched_items > 0 ? true : false;
        }
        catch(Exception $e){
            return $e->getMessage();
        }
        
    }
}