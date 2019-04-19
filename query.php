<?php
  session_start();
?>
<html>

<head>

  <title> FIR Portal </title>

  <style>

  body {font-family: Arial, Helvetica, sans-serif;}

  /* Full-width input fields */
  input[type=text] {
    width: 90%;
    height: 6%;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
    overflow:scroll;
  }

  #file:hover{
   cursor: pointer;
  }

  #history:hover{
   cursor: pointer;
  }

  #history{
    /*background-image: url('./images/history.png');
    background-repeat: no-repeat;*/
    background-color: red;
    margin-left: -2%;
    width: 50%;
    height: 7%;
    margin-top: 2%;
  }

  #file{
    background-color: red;
    width: 50%;
    height: 7%;
    margin-top: 2%;
  }

  #id02{
    width:45%;
    border-style: solid;
    border-color: black;
    padding: 2%;
    margin-left: 25%;
    margin-top: -10%;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0, 0.4);
    display: none;
  }

  #id03{
    display: none;
    border-style: solid;
    border-color: blue;
    width: 50%;
    border-radius: 10%;
    padding: 1%;
    margin-left: 20%;
    margin-top: -10%;
  }

  td,th{
    padding: 9px;
  }

  </style>
</head>

<!--  Query Page for normal users. -->
<body>

  <?php
    $sql = "select StationID from Station;";
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
   ?>

  <h2 style="margin-left: 40%; margin-top: 3%;">
    FIR Portal
  </h2>

  <table style="margin-left: 2%;">

    <tr> <td>
      <img src="./images/user.png" alt="Login Avatar" height="30%" width="30%"> <br/>
      Welcome <?php echo $_SESSION['username'] ?>
    </td> <tr>

    <tr> <td>
      <button id="file" onclick="document.getElementById('id02').style.display='block'">File Online FIR</button>
    </td> </tr>

    <tr> <td>
      <button id="history" onclick="document.getElementById('id03').style.display='block'">View your FIR filing history</button>
    </td> </tr>

  </table>

   <div id="fileFIR">
     <form id="id02" action="./query.php" method="post">

       <label for="uname"><b>UserName</b></label> <br/>
       <input type="text" placeholder="<?php echo $_SESSION['username']; ?>" name="cid" readonly> <br/> <br/>

       <label for="date"><b>Lodged Date</b></label> <br/>
       <input type="text" placeholder="<?php echo date('d-m-Y: h-i-sa'); ?>" name="cid" readonly> <br/> <br/>

       <label for="ocr"><b>Details of occurrence</b></label> <br/>
       <input type="text" style="height: 40%;" placeholder="Enter place, nature of crime and other relevant details" name="ocr" required> <br/> <br/>

       <label for="descr"><b>Description of accussed</b></label> <br/>
       <input type="text" style="height: 20%;" placeholder="Enter details of the accussed" name="descr" required> <br/> <br/>

       <label for="desc"><b>Station ID</b></label>
       <select name="StationID">
         <?php
           $withdraw = 0;
           $sql = "select StationID from Station;";
           $result = $conn->query($sql);
           if($result->num_rows == 0){
             echo "There is no Station Registered!";
           }
           else{
             while($row = $result->fetch_assoc()) {
               echo "<option value=" . $row['StationID'] . ">" . $row['StationID'] . "</option>";
             }
           }
          ?>
       </select> <br/>

       <button type="submit" name='fileFir' value='fileFir'>File FIR</button>
     </form>
   </div>

   <div id="viewFIR">
     <table id="id03">
       <tr>
         <th>FIR_ID</th>
         <th>Lodged Date</th>
         <th>Description</th>
         <th>StationID</th>
         <th>Status</th>
         <th>Action</th>
       </tr>
       <?php
       $sql = "select * from Fir where Lodger = '" . $_SESSION['username'] . "';";
       $result = $conn->query($sql);
       if ($result->num_rows > 0) {
         while( $row = $result->fetch_assoc() ){
           echo "<tr>";
           echo "<td>" . $row['FirID'] . "</td>";
           echo "<td>" . $row['LodgeDate'] . "</td>";
           echo "<td>" . $row['Descr'] . "</td>";
           echo "<td>" . $row['StationID'] . "</td>";
           echo "<td>" . $row['Status'] . "</td>";
           $action = "NA";
           $withdraw = 0;
           if ($row['Status'] == 'Registered' or $row['Status'] == 'Under Investigation'){
             $action = "<form action='./query.php' method='post'> <input type='hidden' name='firid' value=". $row['FirID']. "><button type='submit' name='withdraw' value='withdraw'> Withdraw </button> </form> ";
           }
           echo "<td>" . $action . "</td>";
           echo "</tr>";
         }
        }
         ?>
     </table>
   </div>

   <?php
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
       if( !empty($_POST['withdraw']) ){
        //  Withdraw the FIR,
        echo "This is a withdraw request";
        $firid = $_POST['firid'];
        echo " ---> " . $firid;
        $sql = 'update Fir set Status = "Withdrawn" where FirID = ' . $firid . ";";
        if (!mysqli_query($conn,$sql)){
          echo("Error description: " . mysqli_error($conn));
        }
        else{
          echo "Your Fir is withdrawn successfully!";
        }
       }
       else{
         echo "FIRfile Inside else";
         $username = $_SESSION['username'];
         $descr = $_REQUEST['ocr'] . ":" . $_REQUEST['descr'];
         $stationid = $_POST['StationID'];
         $sql = "select AadhaarID from User where Username ='" . $username . "';";
         $result = $conn->query($sql);
         if ($result->num_rows > 0) {
           while( $row = $result->fetch_assoc() ){
             $userid = $row['AadhaarID'];
           }
         }
         $sql = "select count(*) as total from Fir;";
         $firid = 1;
         $result = $conn->query($sql);
         if ($result->num_rows > 0){
           while( $row = $result->fetch_assoc() ){
             $firid = $firid + $row['total'];
           }
         }
         echo $firid;
         $sql = "insert into Fir (FirID, Lodger, Descr, StationID, LodgeDate) values (" . $firid . ",'" . $username . "','" . $descr . "'," . $stationid . ",'" . date('Y-m-d') . "');";
         if (!mysqli_query($conn,$sql)){
           echo("Error description: " . mysqli_error($conn));
         }
       }
     }
   ?>

</body>
</html>
