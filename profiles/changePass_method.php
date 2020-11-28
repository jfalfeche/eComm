<?php
    if (isset($_POST['update'])) {
        changePass();
    } else if (!isset($_SESSION['userID'])) {
        header("Location: profile_buyer.php");
    }


    function changePass() {
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
                            echo "<script>window.alert(\"Password successfully updated!\");</script>";
                        } else {
                            // Invalid credentials
                            $isValid = false;
                            echo "<script>window.alert(\"Confirm password not matching\");</script>";
                        }
            } else {
                $isValid = false;
                echo "<script>window.alert(\"Incorrect password.\");</script>";
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
            header("Refresh:0");
        }
    }
?>
