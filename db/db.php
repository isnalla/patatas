<?php

	class Database{
		private $query;
		private $conn;
		private $result;

		//connects the duhhh
        function __construct(){
            if(!isset($_SESSION))
            session_start();
        }
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

        function get_subjects(){
            $this->connect();

            $this->query = "SELECT Course_code from subject";

            $this->result = mysqli_query($this->conn,$this->query);

            for($i = 0; $temp = mysqli_fetch_row($this->result)[0];$i++)
                $subjects[$i] = $temp;

            //var_dump( $subjects);

            if(mysqli_num_rows($this->result) != 0){ //no courses found in database
                $this->close();
                return $subjects;
            }
            else{	//login success
                $this->close();
                return false;
            }

            $this->close();
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

        function get_gradesheets($data){
            $this->connect();

            $this->query = "SELECT * FROM gradesheet gs, department d, subject s
                            WHERE
                            gs.course_code = s.course_code AND
                            s.department = d.department_name AND
                            d.department_head = '" . $_SESSION["name"] . "' AND
                            gs.course_code LIKE '%" . $data['course_code'] . "%'
                            ORDER BY lecturer";

            $this->result = mysqli_query($this->conn,$this->query);

            //var_dump(mysqli_fetch_all($this->result, MYSQLI_ASSOC));

            $this->close();
            echo json_encode(mysqli_fetch_all($this->result, MYSQLI_ASSOC));
        }

        //wala atang overloading sa php =____= so ganito na lang
        function get_gradesheets_by_lecturer(){
            $this->connect();

            $this->query = "SELECT * FROM gradesheet WHERE lecturer = '".$_SESSION['name']."'";

            $this->result = mysqli_query($this->conn,$this->query);

            //var_dump(mysqli_fetch_all($this->result, MYSQLI_ASSOC));
            $this->close();

            //returns an array of users
            echo json_encode(mysqli_fetch_all($this->result, MYSQLI_ASSOC));
        }

        function get_grades($data){
            $this->connect();

            $this->query = "SELECT * FROM grades WHERE lecturer = '".$_SESSION['name']."' AND section = '".$data['section']."'";

            $this->result = mysqli_query($this->conn,$this->query);

            //var_dump(mysqli_fetch_all($this->result, MYSQLI_ASSOC));
            $this->close();

            //returns an array of users
            echo json_encode(mysqli_fetch_all($this->result, MYSQLI_ASSOC));
        }

        function insert_gradesheet($course_code,$section,$grades){

            $this->connect();

            $lecturer = $_SESSION['name'];

            $this->query = "INSERT INTO gradesheet VALUES ('{$lecturer}','{$course_code}','{$section}','PENDING')";

            mysqli_query($this->conn,$this->query);

            $this->query = "INSERT INTO grades VALUES ";
            for($i = 0; $i < count($grades); $i++){
                $student_no = $grades[$i]["student_no"];
                $grade = $grades[$i]["grade"];
                $remarks = $grades[$i]["remarks"];
                $this->query .= "('{$lecturer}','{$student_no}','{$course_code}','{$section}','{$grade}','${remarks}')";
                if($i+1 != count($grades))
                    $this->query .= ",";
            }

            mysqli_query($this->conn,$this->query);

            //temporary error reporter
            if(mysqli_error($this->conn)){
                echo "Upload failed!<br />";
                echo mysqli_error($this->conn);
            }
            else echo "Upload success!";

            $this->close();
        }

        function get_department(){
            $this->connect();

            $this->query = "SELECT * FROM department WHERE department_head = '" . $_SESSION['name'] . "'";
            $this->result = mysqli_query($this->conn,$this->query);

            $this->close();

            return json_encode(mysqli_fetch_all($this->result, MYSQLI_ASSOC));

        }

        function update_gradesheet($data){
            $this->connect();

            $this->query = "UPDATE gradesheet SET status ='" . $data['status'] . "'
                            WHERE
                            course_code = '" . $data['course_code'] . "' AND
                            section = '" . $data['section'] . "'"; //-----------------------EDIT NEXT
            $this->result = mysqli_query($this->conn,$this->query);

            $this->close();

            return json_encode(mysqli_fetch_all($this->result, MYSQLI_ASSOC));
        }
	}
     $db = new Database();
    //nageeror kase tsaka di ko alam kung para saan to kaya cinomment out ko muna
   // $method_name = $_POST['method'];
    //$db->{$method_name}();
?>
