<?php
include_once "../application/PDOController.php";
include_once "../application/RequestAPI.php";
include_once "../application/DataStream.php";
    session_start();
    $method = RequestAPI::getMethod();
    if(!isset($_SESSION['userId'])){
        header('Location: ../');
    }
    if(isset($_GET['logout'])){
        session_destroy();
        header('Location: ../');
    }
    if($method == "POST") {
        if(isset($_POST['program'])){
           $result = putCommand("UPDATE `users` SET `program` = :program WHERE `userId` = :userId",[
               "userId"=>$_SESSION['userId'],
               'program' => $_POST['program']
           ]);
        }
    }
    global $user;
    $user = (new DataStream())
        ->getFromQuery("SELECT * FROM users WHERE userId = $_SESSION[userId]")
        ->get()[0];

    $availablePrograms = (new DataStream())
        ->getFromQuery("SELECT * FROM programs")
        ->get();
    $currentProgram = (new DataStream($availablePrograms))
        ->filter(function ($item){
            global $user;
            return $item['programId'] == $user['program'];
        })->toArray()->get()[0];

    ?>

<p>
    Zalogowano jako <?php echo $user['login']; ?>
</p>
<p>
    Twoj aktualnie wybrany program <?php echo $currentProgram['programDescription'] ?>
</p>
<form method="post">
    <select name="program">
        <?php
            foreach ($availablePrograms as $availableProgram){
                echo "<option ".($currentProgram['programId'] == $availableProgram['programId'] ? "selected" : "")." value='$availableProgram[programId]'>
                        $availableProgram[programDescription]
                      </option>";
            }
        ?>
    </select>
    <button>Zapisz</button>
</form>
<a href="?logout">Wyloguj</a>


