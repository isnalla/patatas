<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Allan
 * Date: 10/16/13
 * Time: 4:04 PM
 * To change this template use File | Settings | File Templates.
 */

    class Lecturer{

        function __construct(){
            include("../db/db.php");
        }

        function get_gradesheets(){
            $db = new Database();
            $res = $db->get_gradesheets_by_lecturer();

            echo $res ;
        }

        function delete_gradesheet($data){
            $db = new Database();
            $res = $db->delete_gradesheet($data);
            echo $res;
        }

        function get_grades($data){
            $db = new Database();
            $res = $db->get_grades($data);

          echo $res;
        }

        function insert_grade($data){
            $db = new Database();
            $res = $db->insert_grade($data);

            echo $res;
        }

        function delete_grade($data){
            $db = new Database();
            $db->delete_grade($data);
        }

        function update_grade($data){
            $db = new Database();
            $db->update_grade($data);
        }

    }

    $lec = new Lecturer();
    $method_name = $_POST['method'];
    if(isset($_POST['data'])){
        $data = $_POST['data'];
        $lec->{$method_name}($data);
    }
    else $lec->{$method_name}();

?>