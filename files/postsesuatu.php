<?php
	require '../db_remote.php';
	session_start();

	if (isset($_POST['submitPost'])) {
		if (isset($_SESSION['username'])) {
			if (!empty($_POST['message'])){
				$message = stripcslashes($_POST['message']);
				$message = mysqli_real_escape_string($con, $message);

				$file = $_FILES['file'];

				$fileTmpName = $file['tmp_name'];
				$fileDestination;
				if (!empty($fileTmpName)) {
					$fileName = $file['name'];
					$fileType = $file['type'];
					$fileErrors = $file['error'];
					$fileSize = $file['size'];

					$explodedFile = explode('.', $fileName);
					$fileExt = strtolower(end($explodedFile));

					$allowedExtensions = array('jpg', 'jpeg', 'png');

					if ($fileErrors == 0) {
						if (in_array($fileExt, $allowedExtensions)) {
							if ($fileSize <= 2000000) {
								$imgNewName = "gambar". "." . uniqid("", true) . "." . $fileExt;
								$fileDestination = "../imagesdata/".$imgNewName;
							} 
							else {
								header('Location: ../?postError='."Ukuran foto terlalu besar (gendut)");
							}
						}
						else {
							header('Location: ../?postError='."Foto hanya boleh berbentuk jpg, jpeg, png");
							exit();
						}
					}
					else {
						header('Location: ../?postError='."Error dalam mengupload gambar");
					}

				}
				if (empty($fileDestination)) {
					$fileDestination = "nil";
				}

				echo "</br>".$fileDestination."</br>";

				$template = "INSERT INTO postdata (sendername, message, imgfullname) VALUES (?,?,?);";
				$prpstatement = mysqli_stmt_init($con);

				if (!mysqli_stmt_prepare($prpstatement, $template)) {
					//header('Location: ../?postError='."error code: 10");
					exit();
				}
				else {
					mysqli_stmt_bind_param($prpstatement, 'sss', $_SESSION['username'], $message, $fileDestination);
					mysqli_execute($prpstatement);
					mysqli_stmt_close($prpstatement);

					if (!empty($fileDestination)) {
						move_uploaded_file($fileTmpName, $fileDestination);
					}
					header('Location: ../');
				}
			}
			else {
				header('Location: ../?postError='."mohon masukkan pesan yang ingin diposting");
				exit();
			}
		}
		else {
			header('Location: ../?postError='."anda harus login untuk memposting");
			exit();
		}
	}

?>