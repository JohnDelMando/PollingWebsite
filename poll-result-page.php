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
            <div class="poll-options">
            <?php
                    $query = "SELECT A.answer, COUNT(V.vote_id) AS vote_count 
                                FROM Answers AS A 
                                LEFT JOIN Votes AS V ON A.answer_id = V.answer_id 
                                WHERE A.poll_id = $poll_id GROUP BY A.answer_id";
                    $result = $db->query($query);
                    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($rows as $row) {
                        $choice = $row["answer"];
                        $votes = $row["vote_count"];

                        echo '<div class="poll-option">
                        <label for="option1">'.$votes.'</label> votes -
                        <label for="option1">'.$choice.'</label>
                    </div>';
                    }
                    ?>
            </div>
            <button onclick="window.location.href = 'page-management-page.php'" class="submit-button">RETURN</button>
        </div>
    </div>
</body>

</html>