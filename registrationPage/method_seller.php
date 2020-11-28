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
        $dateCreated = date("Y/m/d");
        $storeStatus = false;
        $storeName = trim($_POST["storeName"]);
        $storeEmail = trim($_POST["storeEmail"]);
        $storeDescription = trim($_POST["storeDescription"]);

        $isValid = true;

        if ($isValid) {
            // Check if Email already exists
            $stmt = $con->prepare("SELECT * FROM sellers WHERE storeEmail = ?");
            $stmt->bind_param("s", $storeEmail);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                $isValid = false;
                $error_message = "Email already exists.";
            }
        }

        if ($isValid) {
            // Check if Store name already exists
            $stmt = $con->prepare("SELECT * FROM sellers WHERE storeName = ?");
            $stmt->bind_param("s", $storeName);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                $isValid = false;
                $error_message = "Store name unavailable/taken";
            }
        }

        // Check if Email is valid or not
        if ($isValid && !filter_var($storeEmail, FILTER_VALIDATE_EMAIL)) {
            $isValid = false;
            $error_message = "Invalid Email.";
        }

        // Insert records to database
        if ($isValid) {
            $insertSQL = "INSERT INTO sellers(datecreated, storeStatus, storeName,storeEmail,storeDescription) values(?,?,?,?,?)";
            $stmt = $con->prepare($insertSQL);
            $stmt->bind_param("sssss", $dateCreated, $storeStatus, $storeName, $storeEmail, $storeDescription);
            $stmt->execute();
            $stmt->close();

            $success_message = "Your application has been submitted.";
        }
    }
    ?>