<?php
$password_err = $new_password_err = "";
if (isset($_POST['update'])) {

    if (empty($_POST['password'])) {
        $password_err = "Please enter your current password";
    }

    $password = $_POST['password'];
    $new_password = $_POST['new_password'];

//check if errors exist
    if (count($error) === 0) {
        $file = file_get_contents('database.json');
        $data = json_decode($file, true);


        $detailsArray = [
            'id' => $id,
            'username' => $usename,
            'password' => $password,
        ];

        //Make sure data exist in our data base
        $check = array_filter($data, function ($array) {
            return $array['id'] == $_POST['id'];
        });

            //getting all other data asides data to be updated
        $NewArray = array_filter($data, function ($array) {
            return $array['id'] != $_POST['id'];
        });

//            if it exists?
        if (count($check) > 0) {
            array_push($NewArray, $detailsArray);

            //empty database file
            file_put_contents("database.json", "");

            //re-populate file with updated details
            file_put_contents("database.json", json_encode($NewArray));

            header("Location:welcome.php");

        } else {
            echo "This data dose not exist in the database";
        }
    }else{
        echo "Check details";
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
<title>Welcome</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="assests/css/style.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</head>
<body>
<div class="signup-form">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		<h2>Update your password</h2>
        <br>

            <?php
				session_start();
                $ID= $_SESSION["ID"];
				$username = $_SESSION["username"];
            ?>
        <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
		<p class="hint-text"><br><b>Welcome </b><?php echo $_SESSION["username"] ?></p>
        <div class="text-center">Want to Leave the Page? <br><a href="logout.php">Logout</a></div>
    </form>
	
</div>
</body>
</html>