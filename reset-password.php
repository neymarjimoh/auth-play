<?php
if (isset($_POST['update'])) {
    $error = [];

    if (empty($_POST['password'])) {
        array_push($error, "How do you login without a password for Christ sake");
    }

    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

//check if errors exist
    if (count($error) === 0) {
        $file = file_get_contents('database.json');
        $data = json_decode($file, true);


        $detailsArray = [
            'id' => $id,
            'name' => $name,
            'email' => $email,
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

            header("Location:index.php?status=1");

        } else {
            echo "This data dose not exist in the database";
        }
    }else{
        echo "Why do you want to use empty for password,Explain?
        <a href='index.php'>Go back joor</a>";
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
    <form action="home.php" method="post" enctype="multipart/form-data">
		<h2>Welcome</h2>
        <br>

            <?php
				session_start();
				include 'database.php';
				$ID= $_SESSION["ID"];
				$sql=mysqli_query($conn,"SELECT * FROM register where ID='$ID' ");
				$row  = mysqli_fetch_array($sql);
            ?>
            
        <img src="upload/<?php echo $row['File'] ?>" height="150" width="150" style="border-radius:50%;display:block;margin-left:auto;margin-right:auto;" />
		<p class="hint-text"><br><b>Welcome </b><?php echo $_SESSION["First_Name"] ?> <?php echo $_SESSION["Last_Name"] ?></p>
        <div class="text-center">Want to Leave the Page? <br><a href="logout.php">Logout</a></div>
    </form>
	
</div>
</body>
</html>