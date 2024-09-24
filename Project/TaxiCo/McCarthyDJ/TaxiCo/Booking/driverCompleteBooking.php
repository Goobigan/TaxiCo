<?php 
session_start();
date_default_timezone_set("Europe/Dublin");
include ("../GeneralHTML/Header.html");


try{
    $pdo = new PDO('mysql:host=localhost;dbname=taxisys; charset=utf8', 'root', '');

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT count(*) as count FROM bookings WHERE driverID = '".$_SESSION["driverID"]."'";
    
    $result = $pdo->query($sql); 

    $count = $result->fetch()['count'];
    
    if ($count==0){
        echo("No bookings.");
        return;
    }
    $sql = "SELECT * FROM bookings WHERE driverID = '".$_SESSION["driverID"]."'";

    $result = $pdo->query($sql); 

    ?>
    <form method="post" class="formGeneral">
    <h2>Current Booking</h2>
    <table class="table table-hover"><thead><th>Customer Username</th><th>Time</th><th>Passengers</th><th>Destination</th><th>Select</th></thead>
    <?php




    while ($row = $result->fetch()){
        $pdo2 = new PDO('mysql:host=localhost;dbname=taxisys; charset=utf8', 'root', '');

$pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql2 = "SELECT username FROM accounts WHERE accountID = '".$row['accountID']."'";

        $result2 = $pdo2->query($sql2); 

        $name = $result2->fetch()['username'];

        echo("<tr class='table-dark'><td>".$name."</td><td>".$row['timestart']."</td><td>".$row['passengers']."</td><td>".$row['destination']."</td><td>");
        if ($row["status"]=='a'){
           echo( "<input type='radio' name='bookingRadio' value=".$row['bookingID']."></td></tr>");
        }else
        {
            echo("completed: €".$row['cost']."</td></tr>");
        }
    }
    $sql = "SELECT count(*) as count FROM bookings WHERE driverID = '".$_SESSION["driverID"]."' and status='a'";
    
    $result = $pdo->query($sql); 

    $count = $result->fetch()['count'];
    
    if ($count>0){
        ?>
        </table>
        <input type='submit' class="btn btn-primary" name='finishBooking' value='FINISHED'>
        </form>
        <?php
    }

    
}
catch(PDOException $e){
    $title = 'An error has occurred';

    $output = 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();

    echo $title."<br>".$output;

}

if (isset($_POST['finishBooking'])){
    try{
        $bookingID = $_POST['bookingRadio'];

        $pdo2 =new PDO('mysql:host=localhost;dbname=taxisys; charset=utf8', 'root', '');

        $pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql2 = "SELECT timeStart FROM bookings WHERE bookingID = '".$bookingID."'";

        $result2 = $pdo2->query($sql2); 

        $timeStart = $result2->fetch()['timeStart'];
        
        $timeEnd=new DateTime(date("Y-m-d H:i:s"));
        $timeEnd->add(new DateInterval('PT30M'));
        $timeEnd=$timeEnd->format('Y-m-d H:i:s');
        
        $timeStart2 = new DateTimeImmutable($timeStart);
        $timeEnd2 = new DateTimeImmutable($timeEnd);
        $diff = $timeStart2->diff($timeEnd2);

        $day=$diff->format("%a");
        $hour=$diff->format("%H");
        $min=$diff->format("%I");
        
        $cost=((((($day*24)+$hour)*60)+$min)*.4)+3.80;
        

        $pdo = new PDO('mysql:host=localhost;dbname=taxisys; charset=utf8', 'root', '');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE  bookings SET  timeend=:timeEnd,cost=:cost,status='f' WHERE bookingID = '".$bookingID."'";
        
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':cost', $cost);
        $stmt->bindValue(':timeEnd', $timeEnd);

        $stmt->execute();

        $sql2 = "UPDATE  drivers SET  status='a' WHERE driverID = '".$_SESSION['driverID']."'";

        $stmt = $pdo->prepare($sql2);

        $stmt->execute();
        

        ?>
        <script>
            
            window.open("driverCompleteBooking.php","_self");
        </script>
    <?php


    }
    catch(PDOException $e){
        $title = 'An error has occurred';

    $output = 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();

    echo $title."<br>".$output;

    }
}
?>
