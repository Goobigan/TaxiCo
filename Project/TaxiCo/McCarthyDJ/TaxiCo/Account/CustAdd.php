<?php
session_start();
include ('../GeneralHTML/header.html');
include ('custCreate.html');


    if (isset($_POST['submitdetails'])) {

    try {
        $name = $_POST['username'];
        
        $password = $_POST['password'];
        
        $phone = $_POST['phone'];
        
        $email = $_POST['email'];

        $pdo = new PDO('mysql:host=localhost;dbname=taxisys; charset=utf8', 'root', '');

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        

        $sql = "INSERT INTO accounts (username, password, emailAddress, phoneNumber, status) VALUES(:name, :password, :email, :phone, 'a')";

        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':phone', $phone);
        $stmt->bindValue(':email', $email);
        
        $stmt->execute();

        $_SESSION["username"]=$name;

        ?>
        <script>
            window.alert("User Created.");
            window.open("custHome.php","_self");
        </script>
        <?php
        

    }
    catch (PDOException $e) {

        $title = 'An error has occurred';

    $output = 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();

    echo $title."<br>".$output;


    }
    }


?>
