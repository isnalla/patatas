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

    Your student number will be your username.
    Your surname will be your password. Case sensitive.
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
