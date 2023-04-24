<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Analiza sprzedaży</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="main">
		<div class="banner">
			<h1 class="naglowek1">
				MY MARKET
			</h1>
			<h3 class="naglowek2">
				 - analiza sprzedaży sklepu internetowego
			</h3>
		</div>
		<div class="orders">
			<div class="lewy">
				<h3 class="titles">Analiza zamówień</h3>
				<hr>
				<form action="index.php" method="POST">
				<label for="firstname">Podaj imię</label>
				<input type="text" name="firstname" ><br>
				<label for="lastname">Podaj nazwisko</label>
				<input type="text" name="lastname" ><br>
				<input type="submit" name="submit" value="pokaż">
				</form>
			</div>
				<div class="prawy">
					<h3 class="titles">Zamówienia</h3>
					<hr>
					<?php
						if(isset($_POST["submit"])){
							$connect = new mysqli("localhost", "root", "", "classicmodels");
							$name = $_POST["firstname"];
							$lastname = $_POST["lastname"];
							if(empty($name) && empty($lastname)){
								$sqlEmpty1 = "SELECT customers.contactFirstName AS `Imię`, customers.contactLastName AS `Nazwisko`, SUM(products.BuyPrice) AS  `Zamówiony towar` FROM customers
								INNER JOIN orders ON customers.customerNumber=orders.customerNumber
								INNER JOIN orderdetails On orders.orderNumber=orderdetails.orderNumber
								INNER JOIN products ON orderdetails.productCode=products.productCode
								GROUP BY customers.customerNumber  ORDER BY `Zamówiony towar` ASC";

								$sqlEmpty2 = "SELECT customers.customerNumber, customers.contactFirstName,
								customers.contactLastName, SUM(payments.amount) AS `Suma płatności` FROM customers
								INNER JOIN payments ON customers.customerNumber = payments.customerNumber
								GROUP BY payments.customerNumber ORDER BY `Suma płatności`";
							

								$result1 = mysqli_query($connect, $sqlEmpty1);
								$result2 = mysqli_query($connect, $sqlEmpty2);
							}else{
								$sqlFull1 = "SELECT customers.contactFirstName AS `Imię`, customers.contactLastName AS `Nazwisko`, SUM(products.BuyPrice) AS  `Zamówiony towar` FROM customers
								INNER JOIN orders ON customers.customerNumber=orders.customerNumber
								INNER JOIN orderdetails On orders.orderNumber=orderdetails.orderNumber
								INNER JOIN products ON orderdetails.productCode=products.productCode
								WHERE contactFirstName = '".$name."' AND contactLastName = '".$lastname."'
								GROUP BY customers.customerNumber  ORDER BY `Zamówiony towar` ASC";

								$sqlFull2 = "SELECT customers.customerNumber, customers.contactFirstName,
								customers.contactLastName, SUM(payments.amount) AS `Suma płatności` FROM customers
								INNER JOIN payments ON customers.customerNumber = payments.customerNumber
								WHERE contactFirstName = '".$name."'AND contactLastName = '".$lastname."'
								GROUP BY payments.customerNumber ORDER BY `Suma płatności`";
								

								$result1 = mysqli_query($connect, $sqlFull1);
								$result2 = mysqli_query($connect, $sqlFull2);
							}
							echo '<table>';
							while($row = mysqli_fetch_array($result1)){
								echo("<tr><td>".$row[0]." </td><td> ".$row[1]." </td><td> ".$row[2]." </td></tr>");
							}
							echo("</table>");
						}
					?>
				</div>
			</div>
			<div class="payments">
				<div class="lewy">
					<h3 class="titles">Analiza płatności</h3>
					<hr>
					<p>Wartość towarów: </p>
					<p>Kwota płatnosci: </p>
				</div>
				<div class="prawy">
					<h3 class="titles">Płatności</h3>
					<hr>
					<?php
					if(isset($_POST["submit"])){
						echo '<table>';
						while($row = mysqli_fetch_array($result2)){
							echo("<tr><td>".$row[0]." </td><td> ".$row[1]." </td><td> ".$row[2]." </td><td> ".$row[3]." </td></tr>");
						}
						echo("</table>");
					}
					?>
				</div>
			</div>
		<div class="stopka">
			<div class="stopkal">
				<p>Autorem aplikacji jest: 0000000000000000</p>
				<ul>
					<li>Skontaktuj się</li>
					<li>Poznaj naszą firmę</li>
				</ul>
			</div>
			<div class="stopkap">
				<img src="logo.png" alt="logo">
			</div>
		</div>
	</div>
</body>
</html>
