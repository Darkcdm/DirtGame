<?php

class dbTool
{
    private function OpenCon()
    {

        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "root";
        $db = "DirtGame";
        $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n" . $conn->error);
        $this->conn = $conn;
        $this->dbhost;

        return $conn;
    }

    private function CloseCon($conn)
    {
        $conn->close();
    }

    public function GetData($sql)
    {
        $this->conn;
        $this->OpenCon();

        $result = $this->conn->query($sql);

        $this->CloseCon($this->conn);

        return $result->fetch_assoc();
    }

    public function GetPureData($sql)
    {
        $this->conn;
        $this->OpenCon();

        $result = $this->conn->query($sql);

        $this->CloseCon($this->conn);

        return $result;
    }

    public function SetData($sql)
    {
        $this->OpenCon();
        $Conn = $this->conn;

        if ($Conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error . "<br>";
            $this->CloseCon($this->conn);
        }

        $this->CloseCon($this->conn);
    }
}
