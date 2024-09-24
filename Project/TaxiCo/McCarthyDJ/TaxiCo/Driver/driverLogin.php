<?php 
session_start();
include ("../GeneralHTML/Header.html");
include ("driverLoginForm.html");


if (isset($_POST['submitdetails'])) {

    try {
        
        $driverID = $_POST['driverID'];
        
        
        
        if ($driverID == '' )
        {

            echo("You did not enter a Driver ID <br> ");

        }
        else
        {
            $pdo = new PDO('mysql:host=localhost;dbname=taxisys; charset=utf8', 'root', '');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $sql = "SELECT COUNT(driverID) as Count FROM drivers WHERE driverID = '".$driverID."'";

            $result = $pdo->query($sql); 
            
            $foundDriver = $result->fetch()['Count'];

            if ($foundDriver==1){
                $_SESSION["driverID"]=$driverID;
                
            ?>
                <script>
                    window.alert("Driver Logged In.");
                    window.open("../Booking/driverCompleteBooking.php","_self");
                </script>
            <?php
            }
            else
            {
                echo ("Driver not found.");
            }

        }   
    }
    catch (PDOException $e) {

        $title = 'An error has occurred';

    $output = 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();

    echo $title."<br>".$output;

    }


}