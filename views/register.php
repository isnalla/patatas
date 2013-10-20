<?php
/**
 * User: Allan
 * Date: 10/19/13
 * Time: 12:41 AM
 */
    if(isset($_POST['register'])){

        $db = new Database();

        $username = $_POST['username'];
        $firstname = $_POST['firstname'];
        $surname = $_POST['surname'];

        $db->register_student($username,$firstname,$surname);
    }
?>

    <h4>Your student number will be your username.
    Your surname will be your password. Case sensitive.</h4>
    <form id="register-form" name="register-form" action="" method="post">
        <div id="username-container">
            <label for="username"> Student Number </label><br />
            <input type="text" id="username" name="username" maxlength="10" required/>
        </div>
        <div id="surname-container">
            <label for="surname"> Surname </label><br />
            <input type="surname" id="surname" name="surname" required/>
        </div>
        <div id="firstname-container">
            <label for="firstname"> First Name </label><br />
            <input type="firstname" id="firstname" name="firstname" required/>
        </div>
        <button type="submit" class="submit-button" id="register" name="register" value="register">Register</button>
    </form>


<script>
    window.onload = function(){
        myform.onsubmit = checkAll;
    }

    function validateUname(){
        str = $("");
        if(str == "")
            msg = "Fill this up.";


        else if(str.match(/^[0-9]{4}-[0-9]{5}$/))
            msg = "Valid";

        else
            msg = "XXXX-XXXXX";

        if(msg =="Valid")
            return true;

        return false;
    }

    function validateSname(){
        str = $("");
        if(str == "")
            msg = "Fill this up.";


        else if(str.match(/^[A-Za-z]+$/))
            msg = "Valid";

        else
            msg = "";

        if(msg =="Valid")
            return true;

        return false;
    }

    function validateFname(){
        str = $("");
        if(str == "")
            msg = "Fill this up.";


        else if(str.match(/^[A-Za-z]+$/))
            msg = "Valid";

        else
            msg = "";

        if(msg =="Valid")
            return true;

        return false;
    }


    function checkAll(){
        if(validateUname() && validateSname() && validateFname())
            return true;

        return false;
    }


</script>
