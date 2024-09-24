<?php
session_start();
include ('../GeneralHTML/header.html');
include ('custLogin.html');


if (isset($_POST['submitdetails'])) {

    try {
        
        $username = $_POST['username'];
        
        $password = $_POST['password'];
        
        
        if ($username == '' or $password == '' )
        {

            echo("You did not complete the insert form correctly <br> ");

        }   
        else{
            $pdo = new PDO('mysql:host=localhost;dbname=taxisys; charset=utf8', 'root', '');

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            

            $sql = "SELECT password,status FROM accounts WHERE username = '".$username."'";


            
            $result = $pdo->query($sql); 
            $foundPassword = $result->fetch();
            if ($password == $foundPassword['password'] && $foundPassword['status'] == 'a' ){
                echo("Username and password entered correctly.");
                $_SESSION["username"]=$username;
                
                ?>
                <script>
                    window.alert("User logged in.");
                    window.open("custHome.php","_self");
                </script>
                <?php
            }else{
                echo("Username or password is incorrect");
            }
            


        }

    }
    catch (PDOException $e) {

        $title = 'An error has occurred';

    $output = 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();

    echo $title."<br>".$output;


    }
}


?>
