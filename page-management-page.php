<?php
   session_start();
   require_once("db.php");

   if (!isset($_SESSION["user_id"])) {
       header("Location: main-page.php");
       exit();
   } else {
       $user_id = $_SESSION["user_id"];
       $username = $_SESSION["username"];
       $avatar = $_SESSION["avatar"];
   }

   try {
       $db = new PDO($attr, $db_user, $db_pwd, $options);
   } catch (PDOException $e) {
       throw new PDOException($e->getMessage(), (int)$e->getCode());
   }
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>
    <div class="pmg-header">
        <h3 class="pmg-header-text">MICRO-POLL</h3>
        <button onclick="window.location.href = 'logout.php'" class="exit-button">X</button>
    </div>
    <div class="pmg-main-page">
        <div class="pmg-left-page">
            <div class="pmg-user-profile">
                <img src="<?=$avatar?>" alt="User Avatar" class="pmg-user-avatar">
                <h3 class="pmg-username"><?=$username?></h3>
            </div>
            <button onclick="window.location.href = 'poll-creation-page.php'" class="create-poll-button">CREATE A
                POLL</button>
        </div>
        <div class="pmg-right-page">
            <?php
            $query = "SELECT Polls.poll_id, Polls.user_id, Polls.question, Polls.created_dt, Users.username 
                    FROM Polls 
                    JOIN Users ON Polls.user_id = Users.user_id ORDER BY poll_id desc";
            $result = $db->query($query);
            $rows = $result->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                $question = $row["question"];
                $poll_id = $row["poll_id"];
                $uid = $row["user_id"];
                $uname = $row["username"];
                $date = $row["created_dt"];
                $answer = array("", "", "", "", "");
                $i = 0;

                $query = "SELECT answer FROM Answers WHERE poll_id=$poll_id";
                $result = $db->query($query);
                $choices = $result->fetchAll(PDO::FETCH_ASSOC);

                foreach ($choices as $choice) {
                    $answer[$i] = $choice["answer"]; // Access "answer" using $choice
                    $i++;
                }
                
                echo '<div class="post-card">
                <h2 class="post-title">'.$question.'</h2>
                <div>
                    <label for="option1">'.$answer[0].'</label>
                </div>
                <div>
                    <label for="option2">'.$answer[1].'</label>
                </div>
                <div>
                    <label for="option3">'.$answer[2].'</label>
                </div>
                <div>
                    <label for="option4">'.$answer[3].'</label>
                </div>
                <div>
                    <label for="option5">'.$answer[4].'</label>
                </div>
                <p class="post-details">Posted by '.$uname.' | '.$date.'.</p>
                <a href="poll-vote-page.php?poll_id='.$poll_id.'">VOTE</a> or
                <a href="poll-result-page.php?poll_id='.$poll_id.'">show result</a>
            </div>';
            }
            ?>
        </div>
    </div>
</body>

</html>