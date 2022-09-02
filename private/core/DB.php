<?php
class DB
{
    public $conn;
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'project_database';

    function __construct()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        mysqli_select_db($this->conn, $this->dbname);
        mysqli_query($this->conn, "SET NAMES 'utf8'");
    }
}
