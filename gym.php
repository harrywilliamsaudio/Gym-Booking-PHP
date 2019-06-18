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
				<h1>BodyTech Gym</h1>
			</header>

<!-- Linking to SQL Database -->

<?php
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
?>

<!-- Navigation Menu -->

			<nav>
				<ul class = navList>
					<li class = "navEntry"> <a class = "navEntry" href = "#aboutUs"> About Us </a></li>
					<li class = "navEntry"> <a class = "navEntry" href = "#classInfo"> Classes </a> </li>
					<li class = "navEntry"> <a class = "navEntry" href = "#bookingForm"> Book a Session </a> </li>
				</ul>
			</nav>

<!-- Website purpose explanation -->

<div class = aboutUs>
	<section id = "aboutUs">
		<h4><b>BodyTech Gym</b></h4>
		<p>
			Welcome to the online home of BodyTech Gym.<br>
			Here at BodyTech, we're passionate about getting <b>you</b> in shape.
		</p>
	</section>
</div>


<!-- Class information  -->

<div class = classInfo>
	<section id = "classInfo">
		<p> BodyTech currently offers 5 different classes: </p>
		<ul>
			<li>  Bootcamp </li>
			<li> Boxercise </li>
			<li>  Pilates  </li>
			<li>   Yoga    </li>
			<li>   Zumba   </li>
		</ul>
	</section>
</div>

<!-- Available Classes Table -->

		<div class = "availableClasses">
			<section id = "availableClasses">
				<h3> Session Timetable </h3>

				<table>
					<tr>
						<th class = "corner"></th>
						<th>9:00 </th>
						<th>10:00</th>
						<th>11:00</th>
						<th>13:00</th>
						<th>14:00</th>
					</tr>

					<tr>
						<td class="Day">Monday	 </td>
						<td>Boot Camp</td>
						<td></td>
						<td>Pilates	 </td>
						<td></td>
						<td></td>
					</tr>

					<tr>
						<td class="Day">Tuesday </td>
						<td>Boot Camp</td>
						<td></td>
						<td></td>
						<td>Yoga	</td>
						<td></td>
					</tr>

					<tr>
						<td class="Day"> Wednesday </td>
						<td>Boot Camp   </td>
						<td></td>
						<td>Pilates    </td>
						<td>Yoga	   </td>
						<td></td>
					</tr>

					<tr>
						<td class="Day"> Thursday  </td>
						<td></td>
						<td> Boxercise </td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<!--  -->

					<tr>
						<td class="Day"> Friday   </td>
						<td></td>
						<td> Boxercise</td>
						<td> Pilates  </td>
						<td></td>
						<td> Zumba    </td>
					</tr>

				</table>
			</section>
		</div>

<!-- Input Forms -->

		<div class="bookingForm">
			<section id = "bookingForm">
				<h3> Book a Session </h3>
				<p> Please enter your details into the form below. </p>
				<form action = "gymProcess.php" method = "post">

				<!-- Class Type -->

				<select required id="choose_class" name="class">
					<option value=" " disabled selected>Choose a class</option>

					<?php
					$pdo = new PDO($dsn,$db_username,$db_password,$opt);
					$stmt = $pdo->query("SELECT DISTINCT name, GymClasses.cid FROM GymClasses
										 INNER JOIN Session ON
										 GymClasses.cid = Session.cid WHERE
										 Session.capacity >= 1");

					while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
					{
						echo "<option value = '".$row['cid']."'>".$row['name']."</option>";
					}
					?>
				</select>

				<!-- Class Time & Day -->

				<select required id="dayTime" name="dayTime">
					<option value="" disabled selected>Choose a time</option>
				</select>

				<!-- Script for dynamic drop down menu -->

				<script type="text/javascript">
					document.getElementById("choose_class").addEventListener("change", function()
					{
						let the_class = this.value;

						var xhttp;

						if(window.XMLHttpRequest)
						{
							xhttp = new XMLHttpRequest();
						}
						else
						{
							xhttp = new ActiveXObject('Microsoft.XMLHTTP');
						}

						xhttp.onreadystatechange = function(){
							if(this.readyState == 4 && this.status == 200)
							{
								var response = this.responseText;

								document.getElementById("dayTime").innerHTML =
								'<option value="" disabled selected>Choose a time</option>'
								+ response;
							}
						}

						xhttp.open('GET', 'gymGetDayTime.php?class='+the_class, true);
						xhttp.send();
					});
				</script>

				<input placeholder="Your Name" type="text" name="name" pattern = "[a-zA-Z][a-zA-Z-' ]{0,}"
				 title = "Please enter letters or hyphens only" required> <br>

				<input placeholder="Mobile Number" type="text" name="phone" pattern = "[0][0-9 ]{0,}"
				 title = "Please enter a valid phone number"  required> <br>

				<input type="submit" name = "insert">

			</form>
		</section>
	</div>

<!-- Copyright & Date Modified -->

<footer>
		<?php
			$filename = 'gym.php';
			if (file_exists($filename))
			{
			echo "&copy; Harry Williams<br>";
			echo "Last Modified: ".date("d F Y H:i:s.", filemtime($filename));
			}
		?>
</footer>


<!-- Closing Tags -->

		</article>
	</body>
</html>
