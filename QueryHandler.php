<?php

class QueryHandler{

    static private  $connectionObject = null;
  
    //this function is used to open the connection with ((Any Database)) , Dont't forget to close connection before connection to an other database
    static public function openConnection($Host , $DBName , $DBUserName , $DBUserPassword){
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

    //this method is used to close the connection
    static public function closeConnection(){
        self::$connectionObject = null;
        return true;
    }
 
    //==============================================================================
    //insert Methodes
    //==============================================================================

    //with this method you can insert values by passing tableName and array of values that you want to send it to DB
    //Note : don't forget to open connection before use this method

    static public function insertIntoableByValues($table ,   $ColumnsAndValuesArray){
        
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

    //with this method you can insert values by only passing the insert statement that contains table name and columns and values
    //Note : don't forget to open connection before use this method
    static public function insertIntoableByqueryStatment($statment , $valuesArrayForAlias = array()){
        try{
            if(self::$connectionObject == null){
                throw new Exception("You must open the connection with database first !");
            }
            $insertQuery = self::$connectionObject->prepare($statment);
            $resultOfInserting = $insertQuery->execute($valuesArrayForAlias);
            return $resultOfInserting;
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }

    //==============================================================================
    //remove  Methodes
    //==============================================================================

    static public function removeItemById($table , $id){
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
    
    static public function removeItemByDeleteStatment($statment , $valuesArrayForAlias = array()){
        try{
            if(self::$connectionObject == null){
                throw new Exception("You must open the connection with database first !");
            }
            $delete_query = self::$connectionObject->prepare($statment);
            $resultOfDeleting = $delete_query->execute($valuesArrayForAlias);
            return $resultOfDeleting;
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }

    //==============================================================================
    //Find (get Item Informations)  Methodes
    //==============================================================================
    
    //Note : by this method you can only get one row info ...... to get more than use getItems methods
    static public function getItemAllInfoById($table , $id){
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

    //Note : by this method you can only get one row info ...... to get more than use getItems methods
    static public function getItemSomeInfoById($table , $arrayOfColumns, $id){
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

    //Note : by this method you can only get one row info ...... to get more than use getItems methods
    static public function getItemInfoBySelectStatement($statment , $valuesArrayForAlias = array()){
        try{
            if(self::$connectionObject == null){
                throw new Exception("You must open the connection with database first !");
            }
            $getInfo_query = self::$connectionObject->prepare($statment);
            $getInfo_query->execute($valuesArrayForAlias);
            $row_info = $getInfo_query->fetch();
            return $row_info;
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }

    //Note : by this method you can only get multiple rows info ..... to get one row info use getItemInfo methods
    static public function getItemsSomeInfo($table , $arrayOfColumns){
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

    //Note : by this method you can only get multiple rows info ..... to get one row info use getItemInfo methods
    static public function getItemsInfoBySelectStatement($statment , $valuesArrayForAlias = array()){
        try{
            if(self::$connectionObject == null){
                throw new Exception("You must open the connection with database first !");
            }
            $getInfo_query = self::$connectionObject->prepare($statment);
            $getInfo_query->execute($valuesArrayForAlias);
            $rows_info = $getInfo_query->fetchAll();
            return $rows_info;
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }
 
    //==============================================================================
    //update Methodes
    //==============================================================================
    
    //with this method you can update values by only passing the update statement that contains table name and columns and values
    //Note : don't forget to open connection before use this method
    static public function updateByqueryStatment($statment , $valuesArrayForAlias = array()){
        try{
            if(self::$connectionObject == null){
                throw new Exception("You must open the connection with database first !");
            }
            $updateQuery = self::$connectionObject->prepare($statment);
            $resultOfUpdating = $updateQuery->execute($valuesArrayForAlias);
            return $resultOfUpdating;
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }

    //===============================================================================
    //is item Unique or found Metohds
    //===============================================================================

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