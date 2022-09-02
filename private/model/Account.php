<?php
class Account extends DB
{
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
            $sql = 'INSERT INTO account (' . $field_name . ') VALUES (?,?,?,?,?,?,?,?,?)';
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('sssssssss',
            $field['email'],$field['phoneNumber'],$field['fullname'],$field['gender'],$field['address'],$field['birthday'],
            $field['initialPassword'],$field['createdAt'],$field['updatedAt']);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function SELECT_ONE($condition = '', $conditionValue = '')
    {
        
        $sql = 'SELECT * from account WHERE ' . $condition . ' = "' . $conditionValue . '"';
        $stmt = $this->conn->query($sql);
        $result = mysqli_fetch_array($stmt, MYSQLI_ASSOC);
        return $result ? $result : array();
    }
    
    function SELECT($condition = '', $conditionValue = '')
    {
        $sql = 'SELECT * from `account` WHERE ' . $condition . ' = "' . $conditionValue . '"';
        $stmt = $this->conn->query($sql);
        $result = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
        return $result ? $result : array();
    }

    function SELECT_ORDER_BY_ASC($condition = '', $conditionValue = '',$fieldValue = '')
    {
        // $sql = 'SELECT * from `account` WHERE '. $condition . ' = "' . $conditionValue . '" ORDER BY `'.$fieldValue . '` ASC';
        $sql = 'SELECT * from `account` WHERE ? = ? ORDER BY ? ASC';
        $stmt = $this->conn->prepare($sql);
        $stmt ->bind_param("sss",$condition, $conditionValue, $fieldValue);

        if(!$stmt->execute()){
            die('Can not select : ' . $stmt->error);
        }else{
            $result = $stmt->get_result();
        }
        
        return $result ? $result : array();
    }
    function SELECT_ORDER_BY_DESC($condition = '', $conditionValue = '',$fieldValue = '')
    {
        $sql = 'SELECT * from `account` WHERE '. $condition . ' = "' . $conditionValue . '" ORDER BY `'.$fieldValue . '` DESC';
        $stmt = $this->conn->query($sql);
        $result = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
        return $result ? $result : array();
    }

    function SELECT_ALL()
    {
        $sql = 'SELECT * from account';
        $stmt = $this->conn->query($sql);
        $result = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
        return $result ? $result : array();
    }

    function UPDATE_ONE($conditions = [], $toUpdate = [])
    {
        try {
            $conditionName = array_keys($conditions)[0];
            $conditionValue = $conditions[$conditionName];
            $toUpdateName = array_keys($toUpdate)[0];
            $newValue = $toUpdate[$toUpdateName];
            $sql = 'UPDATE account SET ' . $toUpdateName . ' = ? WHERE ' . $conditionName . ' = ?';
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('ss',$newValue,$conditionValue);
            $stmt->execute();
            $sql = 'UPDATE account SET updatedAt = ? WHERE ' . $conditionName . ' = ?';
            $stmt = $this->conn->prepare($sql);
            $time = time();
            $stmt->bind_param('ss',$time,$conditionValue);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function UPDATE_IMAGE($conditions = [], $toUpdate = [])
    {
        try {
            $conditionName = array_keys($conditions)[0];
            $conditionValue = $conditions[$conditionName];
            $sql = 'UPDATE account SET idCard_front = ?,idCard_back = ? WHERE ' . $conditionName . ' = ?';
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('sss',$toUpdate['idCard_front'],$toUpdate['idCard_back'],$conditionValue);
            $stmt->execute();
            $sql = 'UPDATE account SET updatedAt = ? WHERE ' . $conditionName . ' = ?';
            $stmt = $this->conn->prepare($sql);
            $time = time();
            $stmt->bind_param('ss',$time,$conditionValue);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}
