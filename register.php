<?php
 
// Define variables and initialize with empty values
$username_err = $password_err = $confirm_password_err = $sign_up_err = "";
$password = $username = $confirm_password = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
 
    // validate fields
    if (empty($username)) {
        $username_err = "Please enter a username.";
    } else $username_err = "";

    if(empty($password)){
        $password_err = "Please enter a password.";     
    } elseif (strlen($password) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else $password_err = "";

    if(empty($confirm_password)){
        $confirm_password_err = "Please confirm password.";     
    } elseif(empty($password_err) && ($password != $confirm_password)){
        $confirm_password_err = "Passwords did not match.";
    } else $confirm_password_err = "";
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        if(!file_exists("database.json")){
            fopen("database.json", "w");
        }
        //open the file
        $file = file_get_contents('database.json');
        $data = json_decode($file, true);

        //allocating unique ids
        if (is_array($data) && count($data) === 0) {
            $id = 1;
        } else if (!is_array($data)) {
            $id = 1;
            $data = [];
        } else {
            $TempIdArray = [];
            //collect each id
            foreach ($data as $item){
                array_push($TempIdArray,(int)($item['id']));
            }
                $id =  max($TempIdArray) + 1;
        }

        $detailsArray = [
            'id' => $id,
            'username' => $username,
            'password' => $password,
        ];


        array_push($data, $detailsArray);
        file_put_contents("database.json", json_encode($data));

        echo "Registration successfull";
        
        header("location: login.php");
    }

}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>
