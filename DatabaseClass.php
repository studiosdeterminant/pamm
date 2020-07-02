<?php
class DatabaseClass
{   
    public $con;
    public $dbSelected;
    public $activeConnection;
    public $dataBaseName;
	public $result;
	
    function __construct($dbUserName, $dbPassword, $server)
    {
        $this->con = mysql_connect($server,$dbUserName,$dbPassword);
        if(!$this->con)
        {
            $this->activeConnection = false;
        }
        else
        {
            $this->activeConnection = true;
        }
    }

    public function dbConnect($dbName, $identifier = null)
    {   
        if ($identifier === null)
        {
            $identifier = $this->con;
        }
        $this->dbSelected = mysql_select_db($dbName, $identifier);
        $this->dataBaseName = $dbName;
        if($this->dbSelected != true)
        {
            $this->connectionErrorReport(__LINE__);
        }
    }

    public function query($query)
    {
        if($this->activeConnection == true && $this->dbSelected == true)
        {
            $result = mysql_query($query);// or queryErrorReport($query, __LINE__);
			$this->result = $result;
        }
        else
        {
            $this->connectionErrorReport(__LINE__);
        }
    }
	
	public function getResult()
    {
        return ($this->result);
    }
	
	public function getNumofRows()
    {
        return mysql_num_rows($this->result);
    }
	
	public function getRow()
    {
        return mysql_fetch_row($this->result);
    }
	
	//Get Data in Array form
	public function getDataInArray()
    {
		$res = array();
		$cnt = 0;
        while($row = mysql_fetch_array($this->result)) {
			$res[$cnt] = $row['object_name'];
			$cnt++;
		}
		return $res;
    }
	
	public function getDataSerially($row_name)
	{
		$retarray = array();
		$cnt = count($row_name);
		while($row = mysql_fetch_assoc($this->result)){
			if($cnt==3){
				$retarray[] = array((int)$row[$row_name[0]], (int) $row[$row_name[1]], (int) $row[$row_name[2]]);
			}else{ //cnt =4 [With text]
				$retarray[] = array($row[$row_name[0]], (int) $row[$row_name[1]], (int) $row[$row_name[2]], (int) $row[$row_name[3]]);
			}
		}
		return $retarray;
	}

    public function connectionErrorReport($line = __LINE__)
    {
        $error = "There has been a connection error on line ".$line."</br>";
        if($this->activeConnection == false)
        {
            $error.= "Active Connection Error <br/>";
        }
        if($this->dbSelected  == false)
        {
            $error.= "Data Base Selection Error <br/>";
        }
        die($error.mysql_error());
    }

    public function queryErrorReport($query, $line = __LINE__)
    {
		$this->result = null;
        return ("There was a query error on ".$line."<br />$query<br/>".mysql_error());
    }

    function __destruct() {
        mysql_close($this->con);
    }
}
?>