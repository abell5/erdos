<?php




?>

<html>

<form method="POST" action="">
<input type="hidden" name="type" value=0/>
Username:  <input type="text" name="user"/><br/>
Password:  <input type="password" name="pass"/><br/>
<input type="submit">
</form>

<br/>
<hl>

<form method="POST" action="registerUser.php">
<input type="hidden" name="type" value=1/>
Username:  <input type="text" name="user"/><br/>
Password:  <input type="password" name="pass"/><br/>
Confirm Password:  <input type="password" name="confirmPass"/><br/>
<input type="submit">
</form>


</html>