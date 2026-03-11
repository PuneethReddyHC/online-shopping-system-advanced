
<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', '');
   define('DB_DATABASE', 'onlineshop');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // SECURITY FIX: Validate and sanitize input
  // receive all input values from the form
  $username = trim($_POST['username'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $password_1 = $_POST['password_1'] ?? '';
  $password_2 = $_POST['password_2'] ?? '';

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { 
    array_push($errors, "Username is required"); 
  } elseif (strlen($username) > 100) {
    array_push($errors, "Username is too long (max 100 characters)");
  } elseif (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
    array_push($errors, "Username can only contain letters, numbers, and underscores");
  }
  
  if (empty($email)) { 
    array_push($errors, "Email is required"); 
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    array_push($errors, "Invalid email format");
  } elseif (strlen($email) > 255) {
    array_push($errors, "Email is too long");
  }
  
  if (empty($password_1)) { 
    array_push($errors, "Password is required"); 
  } elseif (strlen($password_1) < 6) {
    array_push($errors, "Password must be at least 6 characters long");
  } elseif (strlen($password_1) > 72) {
    array_push($errors, "Password is too long");
  }
  
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }
  
  // Sanitize after validation
  $username = mysqli_real_escape_string($db, $username);
  $email = mysqli_real_escape_string($db, $email);

  // SECURITY FIX: Use prepared statement to prevent SQL injection
  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM register WHERE Name=? OR email=? LIMIT 1";
  $stmt = mysqli_prepare($db, $user_check_query);
  if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    
    if ($user) { // if user exists
      if ($user['Name'] === $username) {
        array_push($errors, "Username already exists");
      }

      if ($user['email'] === $email) {
        array_push($errors, "email already exists");
      }
    }
  } else {
    array_push($errors, "Database error. Please try again.");
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	// SECURITY FIX: Use prepared statement to prevent SQL injection
  	$query = "INSERT INTO register (Name, email, password) VALUES(?, ?, ?)";
  	$stmt = mysqli_prepare($db, $query);
  	if ($stmt) {
  	  mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);
  	  if (mysqli_stmt_execute($stmt)) {
  	    $_SESSION['Name'] = $username;
  	    $_SESSION['success'] = "You are now logged in";
  	    mysqli_stmt_close($stmt);
  	    header('location: index.php');
  	    exit();
  	  } else {
  	    array_push($errors, "Registration failed. Please try again.");
  	    mysqli_stmt_close($stmt);
  	  }
  	} else {
  	  array_push($errors, "Database error. Please try again.");
  	}
  }
}
if (isset($_POST['login_user'])) {
  // SECURITY FIX: Validate and sanitize input
  $username = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';

  if (empty($username)) {
  	array_push($errors, "email is required");
  } elseif (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
    array_push($errors, "Invalid email format");
  } elseif (strlen($username) > 255) {
    array_push($errors, "Email is too long");
  }
  
  if (empty($password)) {
  	array_push($errors, "Password is required");
  } elseif (strlen($password) > 72) {
    array_push($errors, "Password is too long");
  }
  
  // Sanitize after validation
  $username = mysqli_real_escape_string($db, $username);

  if (count($errors) == 0) {
  	$password = md5($password);
  	// SECURITY FIX: Use prepared statement to prevent SQL injection
  	$query = "SELECT * FROM register WHERE email=? AND password=? LIMIT 1";
  	$stmt = mysqli_prepare($db, $query);
  	if ($stmt) {
  	  mysqli_stmt_bind_param($stmt, "ss", $username, $password);
  	  mysqli_stmt_execute($stmt);
  	  $results = mysqli_stmt_get_result($stmt);
  	  if (mysqli_num_rows($results) == 1) {
  	    $_SESSION['email'] = $username;
  	    $_SESSION['success'] = "You are now logged in";
  	    mysqli_stmt_close($stmt);
  	    header('location: index.php');
  	    exit();
  	  } else {
  	    array_push($errors, "Wrong username/password combination");
  	    mysqli_stmt_close($stmt);
  	  }
  	} else {
  	  array_push($errors, "Database error. Please try again.");
  	}
  }
}

?>