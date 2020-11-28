<?php
    session_start();
    $host = "localhost"; 
    $user = "root"; 
    $password = ""; 
    $dbname = "philcafe"; 

    $con = mysqli_connect($host, $user, $password, $dbname);
    // Check connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $error_message = $success_message = "";

    // Register user
    if (isset($_POST['submit'])) {
        $firstName = trim($_POST["firstName"]);
        $middleName = trim($_POST["middleName"]);
        $lastName = trim($_POST["lastName"]);
        $contactNumber = trim($_POST["contactNumber"]);
        $customerEmail = trim($_POST["customerEmail"]);
        $permanentAddress = trim($_POST["permanentAddress"]);
        $gender = trim($_POST["gender"]);
        $birthday = trim($_POST["birthday"]);
        $password = trim($_POST["password"]);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $confirmPassword = trim($_POST["confirmPassword"]);
        $confirmEmail = trim($_POST["confirmEmail"]);

        $isValid = true;

        if ($isValid) {
            // Check if Email already exists
            $stmt = $con->prepare("SELECT * FROM customers WHERE customerEmail = ?");
            $stmt->bind_param("s", $customerEmail);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                $isValid = false;
                $error_message = "Email already exists.";
            }
        }

        // Check if Email is valid or not
        if ($isValid && !filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
            $isValid = false;
            $error_message = "Invalid Email.";
        }

        // Check if confirm email matches
        if ($isValid && ($customerEmail != $confirmEmail)) {
            $isValid = false;
            $error_message = "Confirm email not matching";
        }

        // Check if confirm password matches
    /*    if ($isValid && ($password != $confirmPassword)) {
           $isValid = false;
           $error_message = "Confirm password not matching";
        } */

        if ($isValid && (password_verify($confirmPassword, $password))) {
          // Success!
            $success_message = "";
        } else {
            // Invalid credentials
            $isValid = false;
            $error_message = "Confirm password not matching";
        } 

        // Insert records to database
        if ($isValid) {
            $insertSQL = "INSERT INTO customers(firstName,middleName,lastName,contactNumber,customerEmail,permanentAddress,gender,birthday,password ) values(?,?,?,?,?,?,?,?,?)";
            $stmt = $con->prepare($insertSQL);
            $stmt->bind_param("sssssssss", $firstName, $middleName, $lastName, $contactNumber, $customerEmail, $permanentAddress, $gender, $birthday, $password);
            $stmt->execute();
            $stmt->close();

            $success_message = "Account created successfully. Please log in your account to continue.";
        }
    }

?>