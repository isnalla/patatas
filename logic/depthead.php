<?php
class Depthead{

    function __construct(){
        include("../db/db.php");
    }

    function get_gradesheets(){
        $db = new Database();
        $res = $db->get_gradesheets();
        //sort by something alog
        echo $res;
    }

}

$dep = new Depthead();
$method_name = $_POST['method'];
$dep->{$method_name}();
?>