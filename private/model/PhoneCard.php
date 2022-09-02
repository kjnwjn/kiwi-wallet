<?php
class PhoneCard extends DB
{
    function SELECT_ONE($condition = '', $conditionValue = '')
    {
        $sql = 'SELECT * from `phoneCard` WHERE ' . $condition . ' = "' . $conditionValue . '"';
        $stmt = $this->conn->query($sql);
        $result = mysqli_fetch_array($stmt, MYSQLI_ASSOC);
        return $result ? $result : array();
    }

    function SELECT($condition = '', $conditionValue = '')
    {
        $sql = 'SELECT * from `phoneCard` WHERE ' . $condition . ' = "' . $conditionValue . '"';
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
        $sql = 'SELECT '. $value.' from phoneCard INNER JOIN '. $table .' ON ' .$condition . '';
        $stmt = $this->conn->query($sql);
        $result = mysqli_fetch_array($stmt, MYSQLI_ASSOC);
        return $result ? $result : array();
    }

    function SELECT_ALL()
    {
        $sql = 'SELECT * from `phoneCard`';
        $stmt = $this->conn->query($sql);
        $result = mysqli_fetch_array($stmt, MYSQLI_ASSOC);
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
           
            $sql = 'INSERT INTO phonecard (' . $field_name . ') VALUES (?,?,?,?,?,?,?)';
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('sssssss',$field['phoneCard_id'],$field['transaction_id'],$field['mno'],
            $field['phoneCardType'],$field['amount'],$field['createdAt'],$field['updatedAt']);
            
            if(!$stmt){
                    return "Prepare failed: (". $this->conn->error.") ".$this->conn->error."<br>";
                 }
           
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            echo $e;
        }
    }

    

    function UPDATE_ONE($conditions = [], $toUpdate = [])
    {
        try {
            $conditionName = array_keys($conditions)[0];
            $conditionValue = $conditions[$conditionName];
            $toUpdateName = array_keys($toUpdate)[0];
            $newValue = $toUpdate[$toUpdateName];
            $sql = 'UPDATE phonecard SET ' . $toUpdateName . ' = ? WHERE ' . $conditionName . ' = ?';
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('ss',$newValue,$conditionValue);
            $stmt->execute();
            $sql = 'UPDATE phonecard SET updatedAt = ? WHERE ' . $conditionName . ' = ?';
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
