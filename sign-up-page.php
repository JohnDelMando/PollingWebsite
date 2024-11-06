<?php
require_once("db.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); //encodes
    return $data;
}

$errors = array();
$email = "";
$username = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST["e-mail"]);
    $username = test_input($_POST["user-name"]);
    $password = test_input($_POST["pass-word"]);
    
    $emailRegex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    $unameRegex = "/^[a-zA-Z0-9_]+$/";
    $passwordRegex = "/^.{8}$/";
    
    if (!preg_match($emailRegex, $email)) {
        $errors["email"] = "Invalid Email";
    }
    if (!preg_match($unameRegex, $username)) {
        $errors["username"] = "Invalid User Name";
    }
    if (!preg_match($passwordRegex, $password)) {
        $errors["password"] = "Invalid Password";
    }

    $target_file = "";

    try {
        $db = new PDO("mysql:host=localhost; dbname=jdp473", "jdp473", "P@tr1ck");
    } catch (PDOException $e) {
        die ("PDO Error >> " . $e->getMessage(). "\n<br />");
    }

    $query = "SELECT * FROM Users WHERE username='$username'";
    $result = $db->query($query);
    $match = $result->fetch();

    if ($match) {
        $errors["Account Taken"] = "A user with that username already exists.";
    }
    
    if (empty($errors)) {
        $query = "INSERT INTO Users (email, username, password, avatar) VALUES ('$email', '$username', '$password', 'empty')";
        $result = $db->exec($query);

        if (!$result) {
            $errors["Database Error:"] = "Failed to insert user";
        } else {
            $target_dir = "uploads/";
            $uploadOk = TRUE;
        
            $imageFileType = strtolower(pathinfo($_FILES["avatar"]["name"],PATHINFO_EXTENSION));

            $uid = $db->lastInsertId();
            
            $target_file = $target_dir . $uid . "." . $imageFileType;

            if (file_exists($target_file)) {
                $errors["avatar"] = "Sorry, file already exists. ";
                $uploadOk = FALSE;
            }
                
            if ($_FILES["avatar"]["size"] > 1000000) {
                $errors["avatar"] = "File is too large. Maximum 1MB. ";
                $uploadOk = FALSE;
            }

            // Check image file type
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                $errors["avatar"] = "Bad image type. Only JPG, JPEG, PNG & GIF files are allowed. ";
                $uploadOk = FALSE;
            }
                            
            // Check if $uploadOk still TRUE after validations
            if ($uploadOk) {
                // Move the user's avatar to the uploads directory and capture the result as $fileStatus.
                $fileStatus = move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);

                // Check $fileStatus:
                if (!$fileStatus) {
                    // The user's avatar file could not be moved
                    // TODO 9a: add a suitable error message to errors array be displayed on the page
                    $errors["Server Error"] = "Avatar could not be uploaded";
                    $uploadOK = FALSE;
                }
            }
            
            // Check if $uploadOk still TRUE after attempt to move
            if (!$uploadOk)
            {
                // TODO 9b: use PDO::exec() with a DELETE FROM statement to remove the temporary user record
                $query = "DELETE FROM Users WHERE user_id=$uid";
                $result = $db->exec($query);
                if (!$result) {
                    $errors["Database Error"] = "could not delete user when avatar upload failed";
                }
                $db = null;
            } else {
                $query =  "UPDATE Users SET avatar='$target_file' WHERE user_id=$uid";
                $result = $db->exec($query);
                if (!$result) {
                    $errors["Database Error:"] = "could not update avatar_url";
                } else {
                    $result = null;
                    $db = null;
                    header ("Location: main-page.php");
                    exit();
                }
            }
        } 
    } 
    
    if (!empty($errors)) {
        foreach($errors as $type => $message) {
            print("$type: $message \n<br />");
        }
    }

}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script src="js/eventHandlers.js"></script>
</head>

<body>
    <div class="main-page">
        <div class="signup-left-page">
            <div class="signup-title">
                <h2 class="the-signup-title">
                    <p>
                        CREATE YOUR
                    </p>
                    <p>
                        ACCOUNT NOW!
                    </p>
                </h2>
            </div>
        </div>
        <div class="right-page">
            <div class="login-form">
                <h1>
                    SIGN UP
                </h1>
                <form action="" method="post" id="my-signup-form" enctype="multipart/form-data">
                        <input type="file" name="avatar" accept="image/*" id="avatarID" style="display: none;">
                        <button class="avatar-button" onclick="document.getElementById('avatarID').click()">SELECT
                        AVATAR</button><br />
                        <p id="avatar-err" class="error-text hidden">Invalid avatar</p>
                        <input type="text" name="e-mail" id="e-mailID" placeholder="E-MAIL" ><br />
                        <p id="email-err" class="error-text hidden">Invalid e-mail</p>
                        <input type="text" name="user-name" id="user-nameID" placeholder="USERNAME" ><br />
                        <p id="user-name-err" class="error-text hidden">Invalid username</p>
                        <input type="password" name="pass-word" id="pass-wordID" placeholder="PASSWORD" ><br />
                        <p id="pass-word-err" class="error-text hidden">Invalid password</p>
                        <input type="password" name="cpass-word" id="cpass-wordID" placeholder="CONFIRM PASSWORD" ><br />
                        <p id="cpass-word-err" class="error-text hidden">Password does not match</p>
                    <p>
                        <input type="submit" value="CREATE ACCOUNT" class="signup-button" />
                    </p>
                </form>
            </div>
        </div>
    </div>
    <script src="js/eventRegisterSignup.js"></script>
</body>

</html>