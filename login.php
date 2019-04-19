<?php
// Start Session
  session_start();
?>

<html>
<head>
  <title>CS315-Project</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
  body {font-family: Arial, Helvetica, sans-serif;}
  /* Full-width input fields */
  input[type=text], input[type=password], input[type=email] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
  }

  .modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 25%;
    border: 1px solid blue;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
    border-radius: 2%;
    padding: 2%;
    margin-left: 65%;
    margin-top: 3%;
  }

  .container {
    padding: 16px;
  }

  /* Modal Content/Box */
  .modal-content {
    background-color: #fefefe;
    margin: 5% auto 15% auto;
    border: 1px solid #888;
    width: 30%;
  }

  #create:hover{
   cursor: pointer;
  }

  /* Add Zoom Animation */
  .animate {
    -webkit-animation: animatezoom 0.6s;
    animation: animatezoom 0.6s
  }

  @-webkit-keyframes animatezoom {
    from {-webkit-transform: scale(0)}
    to {-webkit-transform: scale(1)}
  }

  @keyframes animatezoom {
    from {transform: scale(0)}
    to {transform: scale(1)}
  }
  </style>
</head>

<body>

  <h2 style="margin-left: 30%; margin-top: 5%;">CS315 Project <br/> FIR Management System</h2>
  <img src="./images/police_salute.jpeg" alt="We are always there for you!" height="30%" width="20%" style="margin-left: 8%;">

  <!--  Login Form -->
  <form style="width:25%; border-style: solid; border-color: blue; border-radius: 5%; padding: 2%; margin-left: 30%; margin-top: -15%;" method="post" action="./login.php">
    <div>
      <label for="uname_l"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="uname_l" required>
      <label for="psw_l"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw_l" required>
      <input type="submit">
    </div>
    <br/>
    <b>Create account: </b> </br>
    <img id="create" src="./images/sign-up.png" alt="We are always there for you!" height="50" width="95" style="margin-left: 40%;" onclick="document.getElementById('id01').style.display='block'">
  </form>

  <!--  Sign-Up form -->
  <form id="id01" class="modal" method="post" action="./login.php">
    <div>
      <label for="fname"><b>First Name</b></label>
      <input type="text" placeholder="Enter First Name" name="fname" required>

      <label for="lname"><b>Last Name</b></label>
      <input type="text" placeholder="Enter Last Name" name="lname" required>

      <label for="uname"><b>UserName</b></label>
      <input type="text" placeholder="Enter User Name" name="uname" required>

      <label for="mob"><b>Mobile Number</b></label>
      <input type="text" placeholder="Mobile Number" name="mob" required>

      <label for="id"><b>Citizen Id</b></label>
      <input type="text" placeholder="Citizen ID" name="cid" required>

      <label for="mail"><b>Email Id</b></label>
      <input type="email" placeholder="Enter email" name="mail" required>

      <label for="psw"><b>Enter Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required>

      <button type="submit">Register</button>
    </div>
  </form>

  <?php
    // set connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "asd";
    $db = "FIRM";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $db);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    // $_SESSION['conn'] = $conn;
    echo "Database connected!";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $username = $_REQUEST['uname'];
      $firstname = $_REQUEST['fname'];
      $lastname = $_REQUEST['lname'];
      $name = $firstname." ".$lastname;
      $cid = $_REQUEST['cid'];
      $mob = $_REQUEST['mob'];
      $dob = $_REQUEST['dob'];
      $mail = $_REQUEST['mail'];
      $password = $_REQUEST['psw'];
      $username_l = $_REQUEST['uname_l'];
      $password_l = $_REQUEST['psw_l'];
      $check = !empty($username_l);
      $PerID = 0;
      if($check){
        // Login Form
        $_SESSION['username'] = $username_l;
        $sql = "select Password, Username, PerID from User where Username = '" . $username_l . "' and Password = '" . $password_l . "';";
        $result = $conn->query($sql);
        if($result->num_rows == 0){
          echo "Invalid Username and Password!";
        }
        else{
          while($row = $result->fetch_assoc()) {
            $PerID = $row["PerID"];
            if ($PerID == 777){
              // ADMIN
              header("Location: ./query_admin.php");
            }
            elseif ($PerID == 100){
              // Police
              header("Location: ./query_police.php");
            }
            else{
              // Normal User
              header("Location: ./query.php");
            }
          }
        }
      }
      else{
        // Sign-Up Form
        echo $cid;
        echo $username;
        echo $password;
        echo $mail;
        echo $PerID;
        echo "<br/>";
        $sql = "insert into User (AadhaarID, Username, Password, Email, PerID) values (" . $cid . ",'" . $username . "','" . $password . "','" . $mail . "'," . $PerID . ");";
        echo $sql . "<br/>";
        if (!mysqli_query($conn,$sql)){
          echo("Error description: " . mysqli_error($conn));
        }
      }
    }
  ?>

</body>
</html>
