<?php
class DbCon
{
    public $servername = "localhost";
    public $username = "TajammalH";
    public $password = "TajammalHussain";
    public $dbname = "timesaving_hussain";
    
    function getCon()
    {
        $connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($connection->connect_error) {
          die("Connection failed: " . $connection->connect_error);
        }else
        {
        return $connection;
        }
    }
}
?>