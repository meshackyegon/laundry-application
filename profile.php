<?php  
include ("functions.php");
?>

<?php $results = mysqli_query($db, "SELECT * FROM users"); ?>

<table>
	<thead>
		<tr>
            <th>Username</th>
			<th>Email</th>
            <th>Location</th>
            <th>PhoneNO</th>
            <th>password</th>
			<th colspan="2">Action</th>
		</tr>
	</thead>
	
	<?php while ($row = mysqli_fetch_array($results)) { ?>
		<tr>
			<td><?php echo $row['username']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['location']; ?></td>
            <td><?php echo $row['phoneNo']; ?></td>
			<td><?php echo $row['password']; ?></td>
			<td>
				<a href="register.php?edit=<?php echo $row['id']; ?>" class="edit" >Edit</a>
			</td>
			<td>
				<a href="functions.php?del=<?php echo $row['id']; ?>" class="del">Delete</a>
			</td>
		</tr>
	<?php } ?>
</table>

<form>