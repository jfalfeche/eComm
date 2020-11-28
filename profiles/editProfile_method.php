<?php
    if (isset($_POST['update'])) {
        update_buyer();
    } else if (!isset($_SESSION['userID'])) {
        header("Location: profile_buyer.php");
    }

    function update_buyer()
    {
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

        echo "<script>window.alert(\"Profile Updated.\");</script>";
        unset($_POST['update']);
        header("Refresh:0");
        //header("Location: profile_buyer.php");
    }
?>