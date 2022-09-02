<?php
class Transaction extends DB
{
    function SELECT_ONE($condition = '', $conditionValue = '')
    {
        $sql = 'SELECT * from `transaction` WHERE ' . $condition . ' = "' . $conditionValue . '"';
        $stmt = $this->conn->query($sql);
        $result = mysqli_fetch_array($stmt, MYSQLI_ASSOC);
        return $result ? $result : array();
    }

    function SELECT($condition = '', $conditionValue = '')
    {
        $sql = 'SELECT * from `transaction` WHERE ' . $condition . ' = "' . $conditionValue . '"';
        $stmt = $this->conn->query($sql);
        $result = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
        return $result ? $result : array();
    }
    function SELECT_ORDER_BY_DESC($condition = '', $conditionValue = '',$fieldValue = '')
    {
        $sql = 'SELECT * from `transaction` WHERE '. $condition . ' = "' . $conditionValue . '" ORDER BY `'.$fieldValue . '` DESC';
        $stmt = $this->conn->query($sql);
        $result = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
        return $result ? $result : array();
    }
   
    function SELECT_INNER_JOIN($column = [],$table = '',$condition ='')
    {
        $value_field = [];

        foreach ($column as $key => $value) {
            array_push($value_field, $value );

        }
        
        $value = implode(',', $value_field);
        $sql = 'SELECT '. $value.' from transaction INNER JOIN '. $table .' ON ' .$condition . '';
        $stmt = $this->conn->query($sql);
        $result = mysqli_fetch_array($stmt, MYSQLI_ASSOC);
        return $result ? $result : array();
    }

    function SELECT_ALL()
    {
        $sql = 'SELECT * from `transaction`';
        $stmt = $this->conn->query($sql);
        $result = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
        return $result ? $result : array();
    }
    function INSERT($field = [])
    {
        $key_field = [];
        $value_field = [];

        foreach ($field as $key => $value) {
            array_push($key_field, $key);
            array_push($value_field, '"' . $value . '"');
        }

        $value = implode(',', $value_field);
        $field_name = implode(',', $key_field);

        try {
            if($field['type_transaction'] == '1'){
                $sql = 'INSERT INTO transaction (' . $field_name . ') VALUES (?,?,?,?,?,?,?,?)';
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param('ssssssss',$field['transaction_id'],$field['email'],$field['type_transaction'],
                $field['value_money'],$field['createdAt'],$field['updatedAt'],$field['action'],$field['card_id']);
            }else if($field['type_transaction'] == '2'){
                $sql = 'INSERT INTO transaction (' . $field_name . ') VALUES (?,?,?,?,?,?,?,?,?,?)';
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param('ssssssssss',$field['transaction_id'],$field['email'],$field['phoneRecipient'],
                $field['type_transaction'],$field['value_money'],$field['description'],$field['costBearer'],$field['createdAt'],$field['updatedAt'],$field['action']);
            }else if($field['type_transaction'] == '3'){
                $sql = 'INSERT INTO transaction (' . $field_name . ') VALUES (?,?,?,?,?,?,?,?)';
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param('ssssssss',$field['transaction_id'],$field['email'],$field['type_transaction'],
                $field['value_money'],$field['description'],$field['createdAt'],$field['updatedAt'],$field['action']);
            }else if($field['type_transaction'] == '4'){
                $sql = 'INSERT INTO `transaction` ('  .$field_name. ') VALUES ('.$value.')';
                $result = $this->conn->query($sql);
                if($result){
                    return true;
                    die();
                }
               
            }
            if(!$stmt){
                return "Prepare failed: (". $this->conn->error.") ".$this->conn->error."<br>";
             }
           
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return  false;
        }
    }

    

    function UPDATE_ONE($conditions = [], $toUpdate = [])
    {
        try {
            $conditionName = array_keys($conditions)[0];
            $conditionValue = $conditions[$conditionName];
            $toUpdateName = array_keys($toUpdate)[0];
            $newValue = $toUpdate[$toUpdateName];
            $sql = 'UPDATE transaction SET ' . $toUpdateName . ' = ? WHERE ' . $conditionName . ' = ?';
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('ss',$newValue,$conditionValue);
            $stmt->execute();
            $sql = 'UPDATE transaction SET updatedAt = ? WHERE ' . $conditionName . ' = ?';
            $stmt = $this->conn->prepare($sql);
            $time = time();
            $stmt->bind_param('ss',$time,$conditionValue);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return $e;
        }
    }
    
}
