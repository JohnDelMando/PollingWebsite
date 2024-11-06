<?php
require_once("db.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check whether the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $errors = array();
    $dataOK = TRUE;
    
    $email = test_input($_POST["e-mail"]);
    $emailRegex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    if (!preg_match($emailRegex, $email)) {
        $errors["e-mail"] = "Invalid Email";
        $dataOK = FALSE;
    }

    $password = test_input($_POST["pass-word"]);
    $passwordRegex = "/^.{8}$/";
    if (!preg_match($passwordRegex, $password)) {
        $errors["password"] = "Invalid Password";
        $dataOK = FALSE;
    }

    if ($dataOK) {

        try {
            $db = new PDO($attr, $db_user, $db_pwd, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        $query = "SELECT user_id, email, username, avatar FROM Users WHERE email='$email' AND password='$password'";
        $result = $db->query($query);

        if (!$result) {
            $errors["Database Error"] = "Could not retrieve user information";
        } elseif ($row = $result->fetch()) {
            session_start();

            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["avatar"] = $row["avatar"];

            $db = null;
            header ("Location: page-management-page.php");
            exit();
        } else {
            // login unsuccessful
            $errors["Login Failed"] = "That username/password combination does not exist.";
        }

        $db = null;

    } else {

        $errors['Login Failed'] = "You entered invalid data while logging in.";
    }
    if(!empty($errors)){
        foreach($errors as $type => $message) {
            echo "$type: $message <br />\n";
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
        <div class="left-page">
            <div class="web-title">
                <h2 class="the-title">
                    MICRO-POLL
                </h2>
                <div class="seperator"></div>
                <?php
                    try {
                        $db = new PDO($attr, $db_user, $db_pwd, $options);
                    } catch (PDOException $e) {
                        throw new PDOException($e->getMessage(), (int)$e->getCode());
                    }
                
                    $query = "SELECT * FROM Polls ORDER BY poll_id desc LIMIT 5";
                    $result = $db->query($query);
                    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($rows as $row) {
                        $question = $row["question"];
                        $poll_id = $row["poll_id"];

                        echo '<div class="poll-item">
                        <div class="polling-quest">
                            '.$question.'
                        </div>
                        <div class="poll-result">
                            <a href="poll-vote-page.php?poll_id='.$poll_id.'">VOTE</a> or
                            <a href="poll-result-page.php?poll_id='.$poll_id.'">show result</a>
                        </div>
                    </div>';
                    }
                ?>
            </div>
        </div>
        <div class="right-page">
            <div class="login-form">
                <h1>
                    LOG IN
                </h1>
                <form action="" method="post" id="my-login-form">
                        <input type="text" name="e-mail" id="e-mailID" placeholder="E-MAIL" ><br/>
                        <p id="email-err" class="error-text hidden">Email is invalid</p>
                        <input type="password" name="pass-word" id="pass-wordID" placeholder="PASSWORD" ><br/>
                        <p id="pass-word-err" class="error-text hidden">Password is invalid</p>
                        <p>
                            <input type="submit" value="LOG IN" class="login-button" >
                        </p>
                </form>
                <div>
                    New user can create an account
                    <a href="sign-up-page.php">here</a>!
                </div>
            </div>
        </div>
    </div>
    <script src="js/eventRegisterLogin.js"></script>
</body>

</html>