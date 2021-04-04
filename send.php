<?php
session_start();
session_regenerate_id(true);

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ./admin/login.php");
    exit;
}

// $subject = "This email forwarded from Mohammad";
// $headers = "From: davtxpey@mailf5.com" ;
// $femail = "mqaddumi7994kohaa@gmail.com";
// $message = "Test email";
// if(strlen($message) > 70)
//     $message = wordwrap($message,70);
// $result = mail($femail,$subject,$message,$headers);
//     echo "end $result";



$username = $_SESSION["username"];
// $username = "mohammad";
$email = $_SESSION["email"];
// $email = "davtxpey@mailf5.com";
$fname = "";
$femail = "";
$message = "";
$username_err = $email_err = $fname_err = $femail_err = $message_err = "";
if(isset($_POST['message']))
    $message = $_POST['message'];
else
    $message_err = "Please enter the message";

if (isset($_POST["username"])) {
    $message = $_POST["message"];

    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }
    if (empty(trim($_POST["fname"]))) {
        $fname_err = "Please enter your friend name.";
    } else {
        $fname = trim($_POST["fname"]);
    }
    if (empty(trim($_POST["femail"]))) {
        $femail_err = "Please enter your friend email.";
    } else {
        $femail = trim($_POST["femail"]);
    }

    if (empty($username_err) && empty($email_err) && empty($fname_err) && empty($femail_err) && empty($message_err)) {
        
        //$to = "somebody@example.com";
        $subject = "This email forwarded from $username";
        $headers = "From: $email" ;//. "\r\n";// .
        // "CC: somebodyelse@example.com";
        // use wordwrap() if lines are longer than 70 characters
        if(strlen($message) > 70)
            $message = wordwrap($message,70);
        mail($femail,$subject,$message,$headers);
        header("location: ./index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sending</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font: 14px sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .wrapper {
            width: 350px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <h2>Send To A Friend</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label>Friend Name</label>
                <input type="text" name="fname" class="form-control <?php echo (!empty($fname_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $fname_err; ?></span>
            </div>
            <div class="form-group">
                <label>Friend email</label>
                <input type="email" name="femail" class="form-control <?php echo (!empty($femail_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $femail_err; ?></span>
            </div>
            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea name="message" class="form-control <?php echo (!empty($message_err)) ? 'is-invalid' : ''; ?>" rows="2" columns="70"><?php echo $message; ?></textarea>
                <span class="invalid-feedback"><?php echo $message_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Send">
            </div>
            <p><a href="./index.php">Back to main page</a>.</p>
        </form>
    </div>
</body>

</html>