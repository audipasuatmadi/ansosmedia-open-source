<?php
	session_start();
	include_once './db_remote.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Masuk / Daftar | Antisosial Media</title>
	<link rel="stylesheet" type="text/css" href="./loginstyling.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Acme" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
</head>
<body>

	<section id="login-section">
		<div id="login-container">
			<div id="login-leftgrid">
				<h1>ANSOSMEDIA</h1>
				<h5><span>Anti</span>Sosial Media</h5>
				<p>oleh Putu Audi Pasuatmadi</p>
			</div>
			<div id="login-rightgrid">
				<h3>Masuk / Daftar</h3>
				<form autocomplete="off" method="POST" action="./files/daftarmasuk.php">
					<label for="username">Username</label>
					<input type="text" name="username" placeholder="username" id="username">
					<label for="password">Password</label>
					<input type="password" name="password" placeholder="password" id="password">
					<?php
						if (isset($_GET['errMsg'])) {
							echo "<p class='error'>".$_GET['errMsg']."</p>";
						} elseif (isset($_GET['succMsg'])) {
							echo "<p class='success'>".$_GET['succMsg']."</p>";
						}
					?>
					<button name="login">Masuk</button>
					<button name="signup">Daftar</button>
				</form>
				<p id="deskripsi-larangan">Jangan gunakan username/password yang sama dengan sosial media anda yang lainnya.</br>Password anda diproteksi dengan hashing, dimana tidak ada pihak ke-tiga yang dapat mengetahuinnya termasuk pemegang database. Pokoknya gitu</p>
			</div>
		</div>

		
	</section>



	<section class="gkadaapapa">
		<img src="./assets/logindiatas.jpg">
	</section>

</body>
</html>