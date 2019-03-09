<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link href="bootstrap.min.css"rel="stylesheet">
</head>
<title>View</title>
</head>
<body>
    <div class="container">
        <div class="jumbotron" style="background-color:white;">    
       <table align="center" class="table table-bordered table-striped" style="font-size:17px; border-radius:5px;">
    <?php
    require_once('connection/connection.php');
    $uid='';$sum=''; 
      if(isset($_GET['id']))
       $uid=$_GET['id'];
      
      $sql=mysqli_query($conn,"select * from user where uid='$uid' ");
      $arr=mysqli_fetch_array($sql);

      $name=$arr['name'];
      $email=$arr['email'];
      $current=$arr['current_credit'];
      $phone=$arr['phone_no'];

      $sql1=mysqli_query($conn,"select * from transfers where uid1='$uid' ");
      $arr1=mysqli_fetch_array($sql1);
      $credit=$arr1['credit'];

      $sql2=mysqli_query($conn,'select * from user');

      $result = mysqli_query($conn,"SELECT SUM(credit) creditSum FROM transfers WHERE uid1 = '$uid' ");
      $row = mysqli_fetch_assoc($result); 
      $sum = $row['creditSum'];

      echo"
      <tr>
        <td style='font-size:20px;padding:20px;'>
        <h2 align='center'> Details Of $name </h2> <br>
         <b>User ID-</b> &nbsp;$uid <br>
         <b>Name-</b> &nbsp;$name <br>
         <b>Email ID-</b> &nbsp;$email <br>
         <b>Current Credit-</b> &nbsp;$current <br>
         <b>Total Credit Shared-</b> &nbsp;$sum <br>
         <b>Phone no. :</b> &nbsp;$phone <br><br>
         ";

         $user_id='';
         $curr='';
         $upd='';
         $cd='';
         if(isset($_POST['transfer'])){
            
            $user_id=$_POST['user_id'];
            $curr=$_POST['current'];
            $a=$_POST['user'];
            $cd=$_POST['balance'];

            if($cd!=NULL && $a!=$user_id){
            $sql = "INSERT INTO transfers (uid1, credit, uid2)
                                    VALUES ('$user_id', '$cd', '$a')";

                                $upd=$curr+$cd;
                                mysqli_query($conn,"update user set current_credit='$upd' where uid='$a' ");

                                    if (mysqli_query($conn, $sql)) {
                                        ?>
                                        <script>
                                            alert('Credit Transferred Successfully');
                                            document.location.href='users.php';
                                        </script>
                                        <?php
                                            
                                    }
            
                                    else {
                                        echo "Error: " . $sql . "<br>" . mysqli_error($a);
                                    }
                                    
          }
        
        
        else{
            ?>
            <script>
                alert('Credit  cannot be transferred');
                document.location.href = "users.php";
            </script>
              <?php
        }
    }
    ?>
        
    <form action="view.php" method="POST">
    <input type='hidden' name='user_id' id='user_id' value='<?php echo $uid; ?>'>
    <input type='hidden' name='current' id='current' value='<?php echo $current; ?>'>
        <label>Select users you want to share the credit:</label>
            <select class='form-control' name='user' id='user'>
              <option value='0'>choose</option>
                <?php  
                while($arr2=mysqli_fetch_array($sql2)){

                    $a=$arr2['uid'];
                    $n=$arr2['name'];
              
              echo"      
              <option value='$a'>$n</option>";
                }
              ?>
            </select>
    <br>        
   <label> Enter Credit:</label>
   <input type="number" name='balance' id='balance' class='form-control'>
   <br><br>
            <button type='submit' class='btn btn-warning btn-lg' name="transfer" id='transfer'>Transfer </button>
            </form>
           </td>

</table>

<?php

 
?>


</div>
</div>
</body>
</html>