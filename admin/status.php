<?php
include ("../functions.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Report</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
    <form style="padding-top:50px;" method="post">
        <button type="submit" style="float:left";name="submit">Send mail</button>
    </form>
    <header class="header">Welcome to Laundry Status Report</header>
    <form class="table-output" method="post" action="../function.php">
    <?php $results = mysqli_query($db,"SELECT u.username, u.email, u.phoneNo, l.sdate, l.laundrytype,l.filename, l.pdate
            FROM users u LEFT OUTER JOIN laundry l ON u.id= l.id"); ?>
        <table>
            <thread>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone NO</th>
                    <th>Sdate</th>
                    <th>Type</th>
                    <th>Filename</th>
                    <th>Pdate</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = mysqli_fetch_array($results)) { ?>
                <tr>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['phoneNo']; ?></td>
                    <td><?php echo $row['sdate']; ?></td>
                    <td><?php echo $row['laundrytype']; ?></td>
                    <td><?php echo $row['filename']; ?></td>
                    <td><?php echo $row['pdate']; ?></td>
                </tr>
                <?php }
            //     if(isset($_POST['submit'])){
            //         $t=mysqli_query($db, "SELECT *FROM laundry WHERE pdate='$pdate'; ");
            //         $date=date_create(date("y-m-d"));
            //         echo $date;

            //         while($row=mysqli_fetch_assoc($t)){
            //                $date2=date_create($row['pdate']);
            //                $diff=date_diff($date,$date2);
            //                $day=$diff->format("%a");  
            //                if($day){
            //                 $name_m= $row['username'];
            //                 $sdate=$row['sdate']; 
            //                 $sql_m=mysqli_query($db, "SELECT * FROM laundry WHERE username='$row[username]' ;");

            //                 $t2=mysqli_fetch_assoc($sql_m); 
            //                 $subject="Clothes pick up date";
            //                 $msg="Hello! 
            //                 This is sent to notify you that the clothes are ready to be picked(Id: ".$sdate.") in the next two days";
            //                 $from="from: henry@gmail.com";
            //                 if(mail($t2['email'],$subject, $msg, $from  )){
            //                 ?>
            //                 <script> 
            //                     alert("mail has been sent successfully");
            //                 </script>
            //                <?php 
            //                }else{
            //                 ?>
            //                 <script> 
            //                     alert("mail not sent");
            //                 </script>
            //                <?php    
            //                 }

            //                }
            //         }
            // } 
            ?>
            </thread>
        </table>
    </selection>
     
</body>
</html>