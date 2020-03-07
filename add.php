<?php
session_start();
require_once "pdo.php";
if ( ! isset($_SESSION['name']) ) {
    die('ACCESS DENIED');
}
if (isset($_POST['cancel']) && $_POST['cancel'] == 'Cancel') {
	header("Location: index.php");
	return;
}
if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['model']) 
     && isset($_POST['mileage'])) {
	if (strlen($_POST['make']) < 1 ) {
        $_SESSION['error'] = 'All values are required';
        header("Location: add.php");
		return;
	} elseif (strlen($_POST['model']) < 1 ) {
        $_SESSION['error'] = 'All values are required';
        header("Location: add.php");
		return;
	} elseif (strlen($_POST['year']) < 1 ) {
        $_SESSION['error'] = 'All values are required';
        header("Location: add.php");
		return;
	} elseif (strlen($_POST['mileage']) < 1 ) {
        $_SESSION['error'] = 'All values are required';
        header("Location: add.php");
		return;
	} elseif (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $_SESSION['error'] = 'Mileage and year must be numeric';
        header("Location: add.php");
		return;
    } else {
		$sql = "INSERT INTO autos (make, model, year, mileage) 
				VALUES (:make, :model, :year, :mileage)";
		echo("<pre>\n".$sql."\n</pre>\n");
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
			':make' => $_POST['make'],
			':model' => $_POST['model'],
			':year' => $_POST['year'],
			':mileage' => $_POST['mileage']));
		$_SESSION["success"] = 'added';
		header("Location: index.php");
		return;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>add</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.34.1" />
</head>

<body>
	<div class="container">
	<h1>Adding Autos for <?php echo $_SESSION['name']; ?></h1>
	<?php
		if (isset($_SESSION['error'])) {
			echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
			unset($_SESSION['error']);
		}
	?>
	<form method="post">
	<p>Make:
	<input type="text" name="make" size="60"/></p>
	<p>Model:
	<input type="text" name="model" size="60"/></p>
	<p>Year:
	<input type="text" name="year"/></p>
	<p>Mileage:
	<input type="text" name="mileage"/></p>
	<input type="submit" value="Add">
	<input type="submit" name="cancel" value="Cancel">
	</form>
	
	</div>
</body>

</html>
