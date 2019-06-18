<!DOCTYPE html>
<html lang="en">

<!-- Meta Information -->

	<head>
		<title>Harry Williams Gym</title>
	    <link rel = "stylesheet" href = "gymStyle.css" type = "text/css" >
		<meta charset ="utf-8">
		<meta name = "author"      content = "Harry Williams">
		<meta name = "description" content = "COMP519 PHP Assignment">
	</head>

	<body>
		<article>
			<header>
				<h1>Booking Confirmation</h1>
			</header>


			 <!-- Insert Data into Table -->

		<?php

		// Establish database connection.

				$db_hostname = "student.csc.liv.ac.uk";
				$db_database = "sghwill7";
				$db_username = "sghwill7";
				$db_password = "iwtbfdeacon";
				$db_charset = "utf8mb4";

				$dsn = "mysql:host=$db_hostname;dbname=$db_database;charset=$db_charset";
				$opt = array(
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
					PDO::ATTR_EMULATE_PREPARES => false
				);

		// Instantiate variables from form to be used in output

		$class   = $_POST['class'];
		$dayTime = $_POST['dayTime'];
		$name 	 = $_POST['name'];
		$phone   = $_POST['phone'];

    // Sets className based on cID value

		$className;

		if ($class = "cID001")
		{
			$className = 'Boot Camp';
		}
		elseif ($class = "cID002")
		{
			$className = 'Boxercise';
		}
		elseif ($class = "cID003")
		{
			$className = 'Pilates';
		}
		elseif ($class = "cID004")
		{
			$className = 'Yoga';
		}
		elseif ($class = "cID005")
		{
			$className = 'Zumba';
		}

		// Inserts form data into database.

		try
		{
			$pdo = new PDO($dsn,$db_username,$db_password,$opt);

			// Prepared insert statement with placeholders.

			$stmt = $pdo->prepare("INSERT INTO Bookings (class,dayTime,name,phone)
								   VALUES (:class,:dayTime,:name,:phone)");

			// Executes statement with bound parameters.

			$success = $stmt->execute(array("class" => $_REQUEST["class"],
											"dayTime" => $_REQUEST["dayTime"],
											"name"    => $_REQUEST["name"],
											"phone"   => $_REQUEST["phone"]
											));

			// If booking is successful, confirmation is generated here.

			if ($success)
			{
				echo "<div class = bookingConfirmation>";
				echo "<section>";
				echo "<h4> Booking Confirmed </h4>";
				echo "<p> $name, your booking was a success. See you for $className on $dayTime!<br>";
				echo "If anything changes, we'll contact you on $phone.</p>";
				echo "</section>";
				echo "</div>";
			}

			// Error message for unsuccessful booking.
			else
			{
				echo "I'm sorry, your booking was unsuccessful";
			}

		$pdo = NULL;
		}

		catch (PDOException $e)
		{
			exit("PDO Error: ".$e->getMessage()."<br>");
		}

		// Gets the capacity of the chosen class.

		$pdo = new PDO($dsn,$db_username,$db_password,$opt);
		$stmt = $pdo->prepare("SELECT capacity FROM Session
							 WHERE dayTime = :dayTime");

		$success = $stmt->execute(array("dayTime" => $_REQUEST["dayTime"]));

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$capacity = $row["capacity"];
		}
		$pdo = NULL;

		// Decrements the class capacity field by 1.

		$capacity -= 1;
		$pdo = new PDO($dsn,$db_username,$db_password,$opt);
		$stmt = $pdo->prepare("UPDATE Session SET capacity = :capacity
							 WHERE dayTime = :dayTime");

		$success = $stmt->execute(array("capacity" => $capacity, "dayTime" => $_REQUEST["dayTime"]));
		$pdo = NULL;
		?>

		</article>
    </body>
</html>
