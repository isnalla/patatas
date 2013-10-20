<?php
class Depthead{

    function __construct(){
        include("../db/db.php");
    }

    function get_gradesheets($data){
        $db = new Database();
        $res = $db->get_gradesheets($data);
        //sort by something alog
        //echo $data['course_code'];
        //exit;
        echo $res;
    }

    function download_gradesheet($data){
        $db = new Database();
        $db->download_gradesheet($data);
    }

    function update_gradesheet($data){
        $db = new Database();
        $res = $db->update_gradesheet($data);
        echo $res;
    }

}

$dep = new Depthead();
$method_name = $_POST['method'];

if(isset($_POST['data'])){
    $data = $_POST['data'];
    $dep->{$method_name}($data);
}
else $dep->{$method_name}();

?>