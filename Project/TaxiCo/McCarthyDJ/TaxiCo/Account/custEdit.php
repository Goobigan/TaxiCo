<?php
session_start();
include ('../GeneralHTML/header.html');

if (isset($_POST['submitdetails'])) {
    echo ("HERE");
    try {
        
        $password = $_POST['password'];
        
        $phone = $_POST['phone'];
        
        $email = $_POST['email'];
        
        
       
        if ($password == '' or $phone == '' or $email == '')
        {

            echo("You did not complete the update form correctly <br> ");

        }   
        else{
            $pdo = new PDO('mysql:host=localhost;dbname=taxisys; charset=utf8', 'root', '');

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            
            $sql = "Update accounts SET password=:password, emailAddress=:email, phoneNumber=:phone where username=:username";

            $stmt = $pdo->prepare($sql);
            
            $stmt->bindValue(':username', $_SESSION["username"]);
            $stmt->bindValue(':password', $password);
            $stmt->bindValue(':phone', $phone);
            $stmt->bindValue(':email', $email);
            
            $stmt->execute();
            
            unset($_POST['submitdetails']);


            ?>
                <script>
                    window.alert("User Updated.");
                    window.open("custHome.php","_self");
                </script>
            <?php
        }
        
    }
    catch (PDOException $e) {

        $title = 'An error has occurred';

    $output = 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();

    echo $title."<br>".$output;

    }
}
if(isset($_POST['deleteAccount'])){
try {

    $pdo = new PDO('mysql:host=localhost;dbname=taxisys; charset=utf8', 'root', '');

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT accountID from accounts where username = '".$_SESSION['username']."'";

    $result = $pdo->query($sql); 
    $accountID = $result->fetch()['accountID'];

    $sql = "SELECT COUNT(bookingID) as bookings from Bookings where accountID = ".$accountID." and status='a'";

    $result = $pdo->query($sql); 
    $bookings = $result->fetch()['bookings'];

    if ($bookings>0){
        echo("Cannot delete account with active bookings.");
        return;
    }

    $pdo2 = new PDO('mysql:host=localhost;dbname=taxisys; charset=utf8', 'root', '');

    $pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql2 = "UPDATE accounts SET status='i' where username = '".$_SESSION["username"]."'";
    
    $stmt = $pdo2->prepare($sql2);
    $stmt->execute();

    session_destroy();

    ?>
        <script>
            window.alert("User Deleted.");
            window.open("Homepage.php","_self");
        </script>
    <?php
    }
    catch (PDOException $e) {

        $title = 'An error has occurred';

        $output = 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();

        echo $title."<br>".$output;
    }
}

if(isset($_POST['logout'])){
    session_destroy();
    ?>
        <script>
            window.alert("User logged out.");
            window.open("homepage.php","_self");
        </script>
    <?php
}

include ("custManage.php");
?>
