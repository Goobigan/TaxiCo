<?php
$username=$_SESSION["username"];

$pdo =  new PDO('mysql:host=localhost;dbname=taxisys; charset=utf8', 'root', '');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM accounts WHERE username = '".$username."' and status = 'a'";

$result = $pdo->query($sql); 
$foundUser = $result->fetch();
?>

<form onsubmit="return FormValidationCustomer('custEditForm')" class="formGeneral" name = "custEditForm"  method="post">
<div>
<Legend><?php echo $username ?></Legend>
</div>

Password: <input type="text" name="password" id="password" value = "<?php echo $foundUser["password"]?>"><br>

Email Address: <input type="text" name="email" id="email"value = "<?php echo $foundUser["emailAddress"]?>"><br>

Phone Number: <input type="text" name="phone" id="phone" pattern = "[10]{0-9}" value = "<?php echo $foundUser["phoneNumber"]?>" ><br>
<div>
<input type="submit" class="btn btn-primary" name="submitdetails" value="EDIT" >
<input type="submit" class="btn btn-warning" name="deleteAccount" value="DELETE" >
<input type="submit" class="btn btn-success" name="logout" value="LOGOUT" >
</div>
</form>

</body>

</html>
