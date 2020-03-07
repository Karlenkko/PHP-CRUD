<?php
session_start();
require_once "pdo.php";
if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
}
$stmt = $pdo->query("SELECT year, make, mileage FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>view</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.34.1" />
</head>

<body>
	<div class="container">
	<h1>Tracking Autos for <?php echo $_SESSION['name']; ?></h1>
	<?php
		if ( isset($_SESSION['success']) ) {
			echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
			unset($_SESSION['success']);
		}
	?>
	<h2>Automobiles</h2>
	<ul>
		<?php
			foreach ($rows as $row) {
				echo '<li>';
				echo htmlentities($row['year'].' '.$row['make'].' / '.$row['mileage']);
				echo '</li><br/>';
			}
		?>
	</ul>
	<p><a href="add.php">Add New<text> | </text><a href="logout.php">Logout</p>
	</div>
</body>

</html>
