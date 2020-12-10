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
        $sql = "SELECT password FROM customers WHERE userID=$userID LIMIT 1";
        $result = $conn->query($sql);

        $error_message = $success_message = "";

    if (isset($_POST['update'])) {
        global $conn, $db;

        $userID = $_SESSION['userID'];
        $currPassword = $_POST['currPassword'];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $confirmPassword = $_POST['confirmPassword'];

        $isValid = true;

        $sql = "SELECT password FROM customers WHERE userID = '$userID' LIMIT 1";
        $result = $conn->query($sql);

        if (mysqli_num_rows($result) == 1) {
            $row = $result->fetch_assoc();
            if ($isValid && (password_verify($currPassword, $row['password']))) {
                if ($isValid && (password_verify($confirmPassword, $password))) {
                        // Success!
                            //echo "<script>window.alert(\"Password successfully updated!\");</script>";
                            $success_message = "";
                        } else {
                            // Invalid credentials
                            $isValid = false;
                            //echo "<script>window.alert(\"Confirm password not matching\");</script>";
                            $error_message = "Confirm password not matching.";
                        }
            } else {
                $isValid = false;
                //echo "<script>window.alert(\"Incorrect password.\");</script>";
                $error_message = "Incorrect password.";
            }
        }

        if ($isValid) {  
            $updateSQL = "UPDATE `customers` SET password=? WHERE customers.userID=$userID";
            $stmt = $conn->prepare($updateSQL);
            $stmt->bind_param('s', $password);
            $stmt->execute();
            $stmt->close();

            //echo "<script>window.alert(\"Password changed!\");</script>";
            unset($_POST['update']);
            $success_message = "Password changed.";
        }
    } 
} else header("Location: profile_buyer.php");
?>
