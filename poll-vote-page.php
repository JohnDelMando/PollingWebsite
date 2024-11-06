<?php
session_start();
require_once("db.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); //encodes
    return $data;
}

if (isset($_SESSION["user_id"])) {
    $avatar = $_SESSION["avatar"];
    $poll_id = $_GET['poll_id'];
    try {
        $db = new PDO($attr, $db_user, $db_pwd, $options);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
}
else {
    $avatar = "images/guest.jpg";
    $poll_id = $_GET['poll_id'];
    try {
        $db = new PDO($attr, $db_user, $db_pwd, $options);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["vote"])) {
        $voted = $_POST["vote"];

        $query = "SELECT answer_id FROM Answers WHERE answer = '$voted'";
        $result = $db->query($query);
        $aids = $result->fetchAll(PDO::FETCH_ASSOC);

        foreach ($aids as $aid) {
            $answer_id = $aid['answer_id'];

            if ($voted) {
                $query = "INSERT INTO Votes (answer_id, vote_dt) VALUES ('$answer_id', NOW())";
                $result = $db->exec($query);
                
                header ("Location: poll-result-page.php?poll_id=$poll_id");
                exit();
            } else {
                    echo "Pick a choice to proceed.<br />\n";
                    header ("Location: poll-vote-page.php?poll_id=$poll_id");
                    exit();
            }
        }
    } else {
        echo "No choice has been made.<br />\n";
        header ("Location: poll-vote-page.php?poll_id=$poll_id");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>
    <div class="header">
        <h3 class="header-text">MICRO-POLL</h3>
        <button onclick="window.location.href = 'logout.php'" class="exit-button">X</button>
    </div>
    <div class="container">
        <div class="poll-container">
            <div class="poll-user">
                <img src="<?=$avatar?>" alt="User Avatar" class="user-avatar">
                <span class="username">
                   <?php
                   if (isset($_SESSION["user_id"])) {
                    $username = $_SESSION["username"];
                    echo "$username";
                   }
                   else {
                    echo "GUEST";
                   }
                   ?>
                </span>
            </div>
            <?php
            $query = "SELECT question FROM Polls WHERE poll_id=$poll_id";
            $result = $db->query($query);
            $rows = $result->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
            ?>
            <h2 class="poll-question">
              <?php echo $row["question"];
            ?>
            <?php
            }
            ?>
            </h2>
            <form action="" method="post" id="vote-form">
                <div class="poll-options">
                    <?php
                    $answer = array("", "", "", "", "");
                    $i = 0;

                    $query = "SELECT answer FROM Answers WHERE poll_id=$poll_id";
                    $result = $db->query($query);
                    $rows = $result->fetchAll(PDO::FETCH_ASSOC);
                
                    foreach ($rows as $row) {
                        $answer[$i] = $row["answer"];
                        $i++;
                    }

                    echo '<div class="poll-option">
                    <input type="radio" id="option1" name="vote" value="'.$answer[0].'">
                    <label for="option1">'.$answer[0].'</label>
                    </div>
                    <div class="poll-option">
                    <input type="radio" id="option1" name="vote" value="'.$answer[1].'">
                    <label for="option1">'.$answer[1].'</label>
                    </div>
                    <div class="poll-option">
                    <input type="radio" id="option1" name="vote" value="'.$answer[2].'">
                    <label for="option1">'.$answer[2].'</label>
                    </div>
                    <div class="poll-option">
                    <input type="radio" id="option1" name="vote" value="'.$answer[3].'">
                    <label for="option1">'.$answer[3].'</label>
                    </div>
                    <div class="poll-option">
                    <input type="radio" id="option1" name="vote" value="'.$answer[4].'">
                    <label for="option1">'.$answer[4].'</label>
                    </div>';
                    ?>
                    <input type="submit" value="VOTE" class="submit-button">
                </div>
            </form>
        </div>
    </div>
</body>

</html>