<?php
	
	include '../db_remote.php';
	if (isset($_POST['submitHapus'])) {
		$idHapus = $_POST['submitHapus'];
		$query = "DELETE FROM postdata WHERE id = ?;";
		$prpStmt = mysqli_stmt_init($con);

		if (!mysqli_stmt_prepare($prpStmt, $query)) {
			echo "uuu";
		} else {
			mysqli_stmt_bind_param($prpStmt, 'i', $idHapus);
			mysqli_stmt_execute($prpStmt);
			header("Location: ../");
		}
	}


?>