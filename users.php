<html>
    <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link href="bootstrap.min.css"rel="stylesheet">
</head>
<title>Users</title>


<body>
 <div class="container">   
    
<table align="center" border=2 class="table table-bordered table-striped" style="font-size:17px">
<th colspan="7"><h2 align="center">All Users</h2></th>
         <tr>
           <td>Sno.</td>
           <td>Name</td>
           <td>Email ID</td>
           <td>Current Credit</td>
           <td>Credits Shared</td>
           <td>Phone No.</td>
           <td>Actions</td>
    
    <?php
  require_once('connection/connection.php');
 $t=1;
    
  $query=mysqli_query($conn,"select * from user");
  
    while($arr=mysqli_fetch_array($query) ){

        $uid=$arr['uid'];
        $name=$arr['name'];
        $email=$arr['email'];
        $current=$arr['current_credit'];
        $phone=$arr['phone_no'];
        

        $query2=mysqli_query($conn,"select * from transfers where uid1='$uid' ");
        $arr2=mysqli_fetch_array($query2);
        $credit=$arr2['credit'];

        $result = mysqli_query($conn,"SELECT SUM(credit) creditSum FROM transfers WHERE uid1 = '$uid' ");
        $row = mysqli_fetch_assoc($result); 
        $sum = $row['creditSum'];

       echo"
       <tr>
         <td> $t </td>
         <td> $name </td>
         <td> $email </td>
         <td> $current </td>
         <td> $sum </td>
         <td> $phone </td>
         <td>
            <a href='view.php?id=$uid'><button class='btn btn-info'>View</button></a>
          </td> ";
       $t++;
    }

?>

</table>
</div>
</body>
</html>