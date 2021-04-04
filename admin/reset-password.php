<?php
session_start();
session_regenerate_id(true);
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ./login.php");
    exit;
}
 
require_once "DataBase.php";
$connetion = new DataBase();
$link = $connetion->connect();
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
$old_password_err = "";
$old_password = $_SESSION["password"];
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    if(empty($new_password_err) && empty($confirm_password_err)){
       
        if($new_password != $old_password){
            $sql = "UPDATE users SET password = ? WHERE email = ?";
            
            if($stmt = mysqli_prepare($link, $sql)){
                mysqli_stmt_bind_param($stmt, "ss", $param_password, $param_email);
                
                $param_password = password_hash($new_password, PASSWORD_DEFAULT);
                $param_email = $_SESSION["email"];
                
                if(mysqli_stmt_execute($stmt)){
                    session_destroy();
                    header("location: login.php");
                    exit();
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
                mysqli_stmt_close($stmt);
            }
        }
        else{
            // echo "<script>alert('test ');</script>";
            $old_password_err = "New Password Should't match Old Password";
        }
    }
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ 
            font: 14px sans-serif;
            height:100vh;
            display:flex;
            align-items: center;
            justify-content:center;
        }
        .wrapper{ 
            width: 350px; 
            padding: 20px;
            box-shadow: 4px 4px 5px #aaaaaa,
                        -4px -4px 5px #aaaaaa; 
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Reset Password</h2>
        <p>Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group">
                <label>Old Password</label>
                <input type="text" name="old_password" value="<?php echo $_SESSION["password"] ?>" class="form-control <?php echo (!empty($old_password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $old_password_err; ?></span>
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link ml-2" href="../index.php">Cancel</a>
            </div>
        </form>
    </div>    
</body>
</html>