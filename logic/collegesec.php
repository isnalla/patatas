<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Allan
 * Date: 10/16/13
 * Time: 4:04 PM
 * To change this template use File | Settings | File Templates.
 */

    class Collegesec{

        function __construct(){
            include("../db/db.php");
        }

        function get_filters(){
            $db = new Database();
            $res['Lecturers'] = $db->get_lecturers();
            $res['Subjects'] = $db->get_subjects_by_department();
            $res['Departments'] = $db->get_departments();

            echo json_encode($res);
        }

        function get_gradesheets_filtered($data){
            $db = new Database();

            $res = $db->get_gradesheets_filtered($data);

            echo $res;
        }

    }

    $colsec = new Collegesec();
    $method_name = $_POST['method'];
    if(isset($_POST['data'])){
        $data = $_POST['data'];
        $colsec->{$method_name}($data);
    }
    else $colsec->{$method_name}();

?>