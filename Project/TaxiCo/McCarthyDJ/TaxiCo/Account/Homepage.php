<?php
  session_start();
  include ('../GeneralHTML/header.html');
  

  $pdo =  new PDO('mysql:host=localhost;dbname=taxisys; charset=utf8', 'root', '');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          
  if (isset($_SESSION['username'])){


      $sql = "SELECT status FROM accounts WHERE username = '".$_SESSION['username']."'";

      $result = $pdo->query($sql); 
      $status = $result->fetch()['status'];

      if ($status=='a'){
        
        ?>
        <script>
            window.open("custHome.php","_self");
        </script>
    <?php
      }
  }
    
?>
  <form>
   <h2><a href="checkLogin.php">Login</a><br>
   <a href="custAdd.php">Create Account</a>
   
   </h2>
  </form>
  </body>
</html>
