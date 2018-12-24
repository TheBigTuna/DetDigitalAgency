<?php

    $msgName = $_POST['name'];
    $msgEmail = $_POST['email'];
    $msgSubject = $_POST['subject'];
    $msgMessage = $_POST['message'];
    $msgSubmit = $_POST['submit'];

    if(empty($msgName && $msgEmail && $msgSubject && $msgMessage)){
        echo 'please fill out the form in its entirety';
        header("Location: ../index.php?message=fail");
            exit();
    }
    else{
        include_once("dbh.php");
        echo 'Thank you for the message<br>';
        $sql = "SELECT * FROM detda;";
        $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql)) {
                echo 'SQL statement failed!#1<br>';
            }

            else{
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $rowCount = mysqli_num_rows($result);
                $setMsgOrder = $rowCount +1;
                echo 'SQL statement passed<br>';

                $sql = "INSERT INTO detda (name, email, subject, message, msgOrder) VALUES (?, ?, ?, ?, ?);";
                    if(!mysqli_stmt_prepare($stmt, $sql)) {
                        echo "SQL statement failed!#2<br>";
                 }
                    else {
                        mysqli_stmt_bind_param($stmt, 'sssss', $msgName, $msgEmail, $msgMessage, $msgSubject, $setMsgOrder);
                        mysqli_stmt_execute($stmt);
                        echo "SQL statement passed#2<br>";
                         header("Location: ../index.php?upload=success");
                    }
            }
        
    }
