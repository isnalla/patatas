<?php

	class Database{
		private $query;
		private $conn;
		private $result;

		//connects the duhhh
		function connect(){
			$this->conn = mysqli_connect("localhost","root","","ogsps") or die("Error Connecting: " . mysqli_error($this->conn));
		}

		//close the duhhhh
		function close(){
			mysqli_close($this->conn);
		}

		//returns an associative array of users
		function get_users(){
			$this->connect();

			$this->query = "SELECT * FROM user";

			$this->result = mysqli_query($this->conn,$this->query);

			//var_dump(mysqli_fetch_all($this->result, MYSQLI_ASSOC));
			$this->close();

			//returns an array of users
			return mysqli_fetch_all($this->result, MYSQLI_ASSOC);
		}

		function login($username,$password){
			$this->connect();

			$this->query = "SELECT role,username,name FROM user WHERE Username='$username' AND password='$password'";

            $this->result = mysqli_query($this->conn,$this->query);

            //var_dump($this->result);
            if(mysqli_num_rows($this->result) != 1){ //user/pass not in database
            	$this->close();
            	return false;
            }
            else{	//login success
            	$this->close();
                return mysqli_fetch_assoc($this->result);
            }
		}
	}
?>