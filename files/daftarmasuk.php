<?php
	require "../db_remote.php";
	session_start();

	function checkForUsername($userName) {
		require "../db_remote.php";

		$template = "SELECT * FROM userdata WHERE username = ?;";
		$prpStmt = mysqli_stmt_init($con);
		if (!mysqli_stmt_prepare($prpStmt, $template)) {
			header("Location: ../login?errMsg=Terjadi kesalahan di database, mohon dilaporkan :(");
		} 
		else {
			mysqli_stmt_bind_param($prpStmt, 's', $userName);
			mysqli_execute($prpStmt);

			$result = mysqli_stmt_get_result($prpStmt);
			$rownumber = mysqli_num_rows($result);
			return $rownumber;
		}
	}


	if (isset($_POST['signup'])) {
		$userName = $_POST['username'];
		$password = $_POST['password'];

		if (empty($userName) || empty($password)) {
			header("Location: ../login?errMsg=Mohon diisi username & passwordnnya");
		}
		else {
			$userName = stripcslashes($userName);
			$userName = mysqli_real_escape_string($con, $userName);
			$password = mysqli_real_escape_string($con, $password);

			$rowNum = checkForUsername($userName);
			if ($rowNum > 0){
				header("Location: ../login?errMsg=Username dengan nama ".$userName." telah terdaftar, coba yang lain");
			} else {
				$password = password_hash($password, PASSWORD_DEFAULT);
				$template = "INSERT INTO userdata (username, password) VALUES (?, ?);";
				$prpStmt = mysqli_stmt_init($con);

				if (!mysqli_stmt_prepare($prpStmt, $template)) {
					header("Location: ../login?errMsg=Terjadi kesalahan di database, mohon dilaporkan :(");
				}
				else {
					mysqli_stmt_bind_param($prpStmt, 'ss', $userName, $password);
					mysqli_stmt_execute($prpStmt);
					mysqli_stmt_close($prpStmt);
					header("Location: ../login?succMsg=Akun berhasil dibuat! mohon masuk dengan akun anda");
				}
			}
		}
	}

	if (isset($_POST['login'])) {
		$userName = $_POST['username'];
		$password = $_POST['password'];
		$userName = stripcslashes($userName);
		$userName = mysqli_real_escape_string($con, $userName);
		$password = mysqli_real_escape_string($con, $password);

		$template = "SELECT * FROM userdata WHERE username = ?;";
		$prpStmt = mysqli_stmt_init($con);
		if (!mysqli_stmt_prepare($prpStmt, $template)) {
			header("Location: ../login?errMsg=Terjadi kesalahan di database, mohon dilaporkan :(");
		} 
		else {
			mysqli_stmt_bind_param($prpStmt, 's', $userName);
			mysqli_execute($prpStmt);

			$result = mysqli_stmt_get_result($prpStmt);
			$rownumber = mysqli_num_rows($result);
			
			if ($rownumber == 1) {
				$row = mysqli_fetch_assoc($result);
				echo "string";
				if (password_verify($password, $row['password']) == 1) {
					$_SESSION['userid'] = $row['id'];
					$_SESSION['username'] = $row['username'];

					header("Location: ../");
				} else {
					header("Location: ../login?errMsg=Kombinasi username / password anda salah");
				}
			} else {
				header("Location: ../login?errMsg=Kombinasi username / password anda salah");
			}
		}


	}

?>