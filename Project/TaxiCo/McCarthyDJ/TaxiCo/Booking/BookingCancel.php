 <?php
session_start();
include('../GeneralHTML/header.html');


try{
    $pdo = new PDO('mysql:host=localhost;dbname=taxisys; charset=utf8', 'root', '');

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT accountID FROM accounts WHERE username = '".$_SESSION['username']."' and status = 'a'";

    $result = $pdo->query($sql); 

    $accountID = $result->fetch()['accountID'];

    $sql2 = "SELECT * FROM bookings WHERE accountID >= '".$accountID."' and status = 'a'";

    $result = $pdo->query($sql2); 

    ?>
    <form method="post" class="formGeneral">
    <table class="table table-hover"><thead><th>Driver Name</th><th>Time</th><th>Passengers</th><th>Destination</th></thead>
    <?php




    while ($row = $result->fetch()){
        $pdo2 =  new PDO('mysql:host=localhost;dbname=taxisys; charset=utf8', 'root', '');

$pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql3 = "SELECT name FROM drivers WHERE driverID = '".$row['driverID']."'";

        $result2 = $pdo2->query($sql3); 

        $name = $result2->fetch()['name'];

        echo("<tr><td>".$name."</td><td>".$row['timestart']."</td><td>".$row['passengers']."</td><td>".$row['destination']."</td><td><input type='radio' name='bookingRadio' value=".$row['bookingID']."></td></tr>");

    }
    ?>
    </table>
    <input type='submit' name='cancelBooking' id='cancelBooking'value='CANCEL'>
    </form>
    <?php
}
catch(PDOException $e){
    $title = 'An error has occurred';

    $output = 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();

    echo $title."<br>".$output;

}


if (isset($_POST['cancelBooking'])){
    try{
        if(isset($_POST['bookingRadio'])==false){
            echo "No Booking Selected";
            return;
        }
        $bookingID = $_POST['bookingRadio'];

        $pdo =  new PDO('mysql:host=localhost;dbname=taxisys; charset=utf8', 'root', '');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT driverID FROM bookings WHERE bookingID = '".$bookingID."'";
        
        $result = $pdo->query($sql); 

        $driverID = $result->fetch()['driverID'];

        $sql = "DELETE FROM bookings WHERE bookingID = '".$bookingID."'";
        
        $stmt = $pdo->prepare($sql);

        $stmt->execute();

        $sql = "update drivers set status='a' where driverID='".$driverID."'";

        $stmt = $pdo->prepare($sql);

        $stmt->execute();
        ?>
        <script>
            window.alert("Booking Deleted.");
            window.open("../Booking/driverCompleteBooking.php","_self");
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