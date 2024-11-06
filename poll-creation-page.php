<?php
session_start();
require_once("db.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); //encodes
    return $data;
}

$errors = array();
$question = "";
$answers = array("", "", "", "", "");
$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = test_input($_POST["poll-ask"]);
    $open_dt = test_input($_POST["poll-open-time"]);
    $close_dt = test_input($_POST["poll-close-time"]);
    $answers[0] = test_input($_POST["choice-1"]);
    $answers[1] = test_input($_POST["choice-2"]);
    $answers[2] = test_input($_POST["choice-3"]);
    $answers[3] = test_input($_POST["choice-4"]);
    $answers[4] = test_input($_POST["choice-5"]);

    $questionRegex = "/^(?!\s*$).{1,100}$/";
    $answersRegex = "/^(?!\s*$).{0,50}$/";

    if (!preg_match($questionRegex, $question)) {
        $errors["question"] = "Invalid Question";
    }
    for ($i = 0; $i < 5; $i++) {
        if (!preg_match($answersRegex, $answers[$i])) {
            $errors["answers"] = "Invalid Choice";
        }
    }

    try {
        $db = new PDO("mysql:host=localhost; dbname=jdp473", "jdp473", "P@tr1ck");
    } catch (PDOException $e) {
        die ("PDO Error >> " . $e->getMessage(). "\n<br />");
    }

    if (empty($errors)) {
        $query = "INSERT INTO Polls (user_id, question, created_dt, open_dt, close_dt, last_vote_dt) VALUES ('$user_id', '$question', NOW(), '$open_dt', '$close_dt', NOW())";
        $result = $db->exec($query);
        
        $poll_id = $db->lastInsertId();

        $query = "INSERT INTO Answers (poll_id, answer) VALUES (?, ?)";
        $result = $db->prepare($query);

        for ($i = 0; $i < 5; $i++) {
            $result->execute([$poll_id, $answers[$i]]);
        }

        $result = null;
        $db = null;
        
        header ("Location: page-management-page.php");
        exit();
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
    <div class="header">
        <h3 class="header-text">MICRO-POLL</h3>
        <button onclick="window.location.href = 'main-page.html'" class="exit-button">X</button>
    </div>
    <div class="container">
        <div class="create-poll-container">
            <h2 class="poll-question">CREATE YOUR POLL</h2>
            <form action="" method="post" id="my-creation-form">
                    <p>
                        <input type="text" name="poll-ask" id="poll-askID" placeholder="TYPE YOUR QUESTION HERE..." ><br />
                        <span id="quest-char" class="qchar-limit">100/100</span><br />
                        <span id="question-err" class="error-text hidden">Character limit exceeded</span>
                    </p>
                    <input type="text" name="choice-1" id="choice-1ID" placeholder="CHOICE #1" ><br />
                    <span id="choice1-char" class="cchar-limit">50/50</span><br />
                    <span id="choice1-err" class="error-text hidden">Character limit exceeded</span><br />
                    <input type="text" name="choice-2" id="choice-2ID" placeholder="CHOICE #2" ><br />
                    <span id="choice2-char" class="cchar-limit">50/50</span><br />
                    <span id="choice2-err" class="error-text hidden">Character limit exceeded</span><br />
                    <input type="text" name="choice-3" id="choice-3ID" placeholder="CHOICE #3" ><br />
                    <span id="choice3-char" class="cchar-limit">50/50</span><br />
                    <span id="choice3-err" class="error-text hidden">Character limit exceeded</span><br />
                    <input type="text" name="choice-4" id="choice-4ID" placeholder="CHOICE #4" ><br />
                    <span id="choice4-char" class="cchar-limit">50/50</span><br />
                    <span id="choice4-err" class="error-text hidden">Character limit exceeded</span><br />
                    <input type="text" name="choice-5" id="choice-5ID" placeholder="CHOICE #5" ><br />
                    <span id="choice5-char" class="cchar-limit">50/50</span><br />
                    <span id="choice5-err" class="error-text hidden">Character limit exceeded</span><br />
                    <span>POLL OPEN TIME:</span><br />
                    <input type="date" name="poll-open-time" id="poll-open-timeID" ><br />
                    <span id="opendate-err" class="error-text hidden">Invalid Open Time</span><br />
                    <span>POLL CLOSE TIME:</span><br />
                    <input type="date" name="poll-close-time" id="poll-close-timeID" ><br />
                    <span id="closedate-err" class="error-text hidden">Invalid Close Time</span><br />
                    <p>
                        <input type="submit" value="CREATE POLL" class="submit-button" >
                    </p>
            </form>
        </div>
    </div>
    <script src="js/eventRegisterCreation.js"></script>
</body>

</html>