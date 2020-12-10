<?php
    session_start();
    if (isset($_SESSION['userID'])) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "philcafe";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        $userID =  $_SESSION['userID'];
        $sql = "SELECT * FROM customers WHERE userID=$userID LIMIT 1";
        $result = $conn->query($sql);

        $error_message = $success_message = "";

        function hide_mail($customerEmail)
        {
            $mail_part = explode("@", $customerEmail);
            $mail_part[0] = substr($customerEmail, 0, 4) . str_repeat("*", strlen($mail_part[0]) - 4);
            return implode("@", $mail_part);
        }

        function hide_mobile($contactNumber)
        {
            $mask_number =  str_repeat("*", strlen($contactNumber) - 4) . substr($contactNumber, -4);
            return $mask_number;
        }

    if (isset($_POST['update'])) {
        global $conn;
    
        $userID = $_SESSION['userID'];
        $firstName = $_POST['firstName'];
        $middleName = $_POST['middleName'];
        $lastName = $_POST['lastName'];
        $contactNumber = $_POST['contactNumber'];
        $customerEmail = $_POST['customerEmail'];
        $permanentAddress = $_POST['permanentAddress'];
        $gender = $_POST['gender'];
        $birthday = $_POST['birthday'];

        //$sql = "UPDATE `customers` SET firstName=$firstName, middleName=$middleName, lastName=$lastName, contactNumber=$contactNumber, customerEmail=$customerEmail, permanentAddress=$permanentAddress, gender=$gender, birthday=$birthday WHERE customerss.userID=$userID";
        $updateSQL = "UPDATE `customers` SET firstName=?, middleName=?, lastName=?, contactNumber=?, customerEmail=?, permanentAddress=?, gender=?, birthday=? WHERE customers.userID=$userID";
        $stmt = $conn->prepare($updateSQL);
        $stmt->bind_param('ssssssss', $firstName, $middleName, $lastName, $contactNumber, $customerEmail, $permanentAddress, $gender, $birthday);
        $stmt->execute();
        $stmt->close();

        //echo "<script>window.alert(\"Profile Updated.\");</script>";
        unset($_POST['update']);
        $success_message = "Profile updated.";
    } } else header("Location: profile_buyer.php");
?>