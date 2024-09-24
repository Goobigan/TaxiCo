<?php
session_start();
date_default_timezone_set("Europe/Dublin");
include ('../GeneralHTML/Header.html');
include ('bookingForm.html');


if (isset($_POST['submitdetails'])) {
    $_SESSION["destination"] = $_POST['destination'];
        
    $_SESSION["passengers"] = $_POST['passengers'];

    try {
        
        if ($_SESSION["destination"] == '' or $_SESSION["passengers"] == '' )
        {

            echo("You did not complete the booking form correctly <br> ");

        }   
        else{
            $pdo = new PDO('mysql:host=localhost;dbname=taxisys; charset=utf8', 'root', '');

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           

            $sql = "SELECT * FROM drivers WHERE carNoSeats >= '".$_SESSION["passengers"]."' and status = 'a'";
           
            $result = $pdo->query($sql); 

            ?>
            <table class="table table-hover"><thead><th>Driver ID</th><th>Name</th><th>Seats</th><th>Select</th></thead>
            <?php



            
            while ($row = $result->fetch()){

                echo("<tr class='table-dark'><td>".$row['driverID']."</td><td>".$row['name']."</td><td>".$row['carNoSeats']."</td><td><input type='radio' name='driverRadio' value=".$row['driverID']."></td></tr>");

            }
            ?>
            </table>
            <input type='submit' class="btn btn-primary" name='bookDriver' id="bookDriver" value='BOOK'>
            
            <?php

            unset($_POST['submitDetails']);
            
        }
       
    }
    catch (PDOException $e) {

        $title = 'An error has occurred';

    $output = 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();

    echo $title."<br>".$output;

    }

    
}
else
{
    if (!(isset($_SESSION["destination"]) && isset($_SESSION["passengers"]) )){
        $_SESSION["destination"] = null;
        $_SESSION["passengers"] = null;
    }
    
}

if (isset($_POST['bookDriver'])){
    try{
        $driverID = $_POST['driverRadio'];
        $pdo = new PDO('mysql:host=localhost;dbname=taxisys; charset=utf8', 'root', '');

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo($_SESSION["username"]);

        $sql = "SELECT accountID FROM accounts WHERE username = '".$_SESSION['username']."' and status = 'a'";

        $result = $pdo->query($sql); 

        $accountID = $result->fetch()['accountID'];
        
        $sql2="INSERT INTO bookings (driverID,accountID,timeStart,destination,passengers,status) VALUES (:driverID,:accountID,CURRENT_TIMESTAMP,:destination,:passengers,'a')";
        
        $stmt = $pdo->prepare($sql2);

        $stmt->bindValue(':driverID', $driverID);
        $stmt->bindValue(':accountID', $accountID);
        $stmt->bindValue(':destination', $_SESSION["destination"]);
        $stmt->bindValue(':passengers', $_SESSION["passengers"]);

        $stmt->execute();
        $_SESSION["destination"]="";
        $_SESSION["passengers"]=0;

        $sql3 = "Update drivers SET status='b' where driverID= :driverID";

        $stmt2 = $pdo->prepare($sql3);

        $stmt2->bindValue(':driverID', $driverID);

        $stmt2->execute();

        ?>
        <?php
        unset($_POST['submitDetails']);

        ?>
        <script>
            window.alert("Booking Made.");
            window.open("../Account/custHome.php","_self");
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
    </form>
    
    </body>
    
    </html>