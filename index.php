<?php
	session_start();
	include_once "./db_remote.php";
?>


<!DOCTYPE html>
<html>
<head>
	<title>Beranda | Antisosial Media</title>
	<link rel="stylesheet" type="text/css" href="./styling.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Acme" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
</head>
	<body id="indexBody">
		<header>
	<div id="actualHeader">
		<div id="hamburgermenu">
			<img src="./assets/Icon_HamburgerTab.png" onclick="getSideBar()">
			<p onclick="getSideBar()">MENU</p>
		</div>
		<div id="brand">
			<h1>ANSOSMEDIA</h1>
		</div>
		<div id="formscontainer">
			<div>
				<?php
					if (isset($_SESSION['userid'])) {
						echo '<form action="./logout.php" method="POST"><button>Logout</button></form>';
					}
					else {
						echo '<form action="./login" method="POST"><button>Masuk/Daftar</button></form>';
					}
				?>

			</div>
		</div>
	</div>

	<div id="sidebar" class="hide">
		<div id="sideBarGrid">
			<div class="menuTitle">
				<h2>MENU</h2>
			</div>

			<div class="profilSaya">
				<?php
					if (isset($_SESSION['username'])) {
						echo "<h3>Manage Profil (".$_SESSION['username'].")(coming soon)</h3>";
					} else {
						echo "<h3>Manage Profil (coming soon)</h3>";
					}
				?>
			</div>

			<div class="kembali-button" onclick="getSideBar()">
				<h3>Kembali</h3>
			</div>

		</div>
	</div>

</header>


		<section id="homeCanvas">
			<div>

			</div>

			<div id="homeFeeds">
				<form id="post-form" method="POST" action="./files/postsesuatu.php" enctype="multipart/form-data">
					<p>Post Sesuatu</p>
					<div id="image-preview" class="noImage">

					</div>
					<textarea name="message" placeholder="Apa yang ingin anda post, hayoo :)"></textarea>
					<?php 
						if (isset($_GET['postError'])) {
							echo '<p id="postError">'.$_GET["postError"].'</p>';
						}
					?>
					<input type="file" name="file" id="upload-image" onchange="onPreviewImage(event)">
					<h5 id="relay-button" onclick="onUploadImageClick(event)">tambahkan foto</h5>
					<button name="submitPost">post</button>
				</form>

				<?php
					$SQLQUERY = "SELECT * FROM postdata ORDER BY id DESC;";
					$prpStatement = mysqli_stmt_init($con);

					if (!mysqli_stmt_prepare($prpStatement, $SQLQUERY)) {
						echo "terjadi sebuah error";
					} else {
						mysqli_stmt_execute($prpStatement);
						$result = mysqli_stmt_get_result($prpStatement);
						$rownumbers = mysqli_num_rows($result);
						if ($rownumbers > 0) {
							while ($row = mysqli_fetch_assoc($result)) {
								if ($row['imgfullname'] == "nil") {
									echo '<div class="post">
					<div class="image-container noimg">

					</div>
					<div class="profile-container">
						<a><p>'.$row['sendername'].'</p></a>
					</div>
					<div class="text-container">
						<p>'.$row['message'].'</p>
					</div>';
								}

								else {
									echo '<div class="post">
					<div class="image-container">
						<img src="./imagesdata/'.$row['imgfullname'].'">
					</div>
					<div class="profile-container">
						<a><p>'.$row['sendername'].'</p></a>
					</div>
					<div class="text-container">
						<p>'.$row['message'].'</p>
					</div>';
								}
								if (isset($_SESSION['username'])){
									if ($row['sendername'] == $_SESSION['username'] || $_SESSION['username'] == 'audip') {
										echo '<form method="POST" action="./files/hapuspost.php">
					<button name="submitHapus" value='.$row['id'].'>Hapus Post</button>
				</form>';
									}
								}

								echo "</div>";
							}
						}
					}
			?>
		</div>

			<div>

			</div>
		</section>

	</body>
	<script type="text/javascript" src="./main.js"></script>
</html>