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
    width: 10%;
    height: 7%;
    margin-top: 2%;
  }

  #file{
    background-color: red;
    width: 10%;
    height: 7%;
    margin-top: 2%;
  }

  #id02{
    width:45%;
    border-style: solid;
    border-color: black;
    padding: 2%;
    margin-left: 25%;
    margin-top: -18%;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0, 0.4);
    display: none;
  }

  #id03{
    display: none;
  }

  </style>
</head>

<!--  Query Page for normal users. -->
<body>

  <h2 style="margin-left: 40%; margin-top: 3%;">
    FIR Portal
  </h2>

  <div style="margin-left: 2%;">

    <div style="margin-top: -3%;">
      <img src="./images/user.png" alt="Login Avatar" height="15%" width="7%"> <br/>
      Welcome <?php echo $_SESSION['username'] ?>
    </div>

    <button id="file" onclick="document.getElementById('id02').style.display='block'">File Online FIR</button>
  </br> <br/>

    <button id="history" onclick="document.getElementById('id03').style.display='block'">View FIR filing history</button>
  </br> <br/>

  </div>

    <!--  Add the feature of withdraing a FIR -->
    <div id="fileFIR">
      <form id="id02" action="./query.php">

        <label for="uname"><b>UserName</b></label> <br/>
        <input type="text" placeholder="<?php echo $_SESSION['username']; ?>" name="cid" readonly> <br/> <br/>

        <label for="date"><b>Lodged Date</b></label> <br/>
        <input type="text" placeholder="<?php echo date('d-m-Y: h-i-sa'); ?>" name="cid" readonly> <br/> <br/>

        <label for="ocr"><b>Details of occurrence</b></label> <br/>
        <input type="text" style="height: 40%;" placeholder="Enter place, nature of crime and other relevant details" name="ocr" required> <br/> <br/>

        <label for="descr"><b>Description of accussed</b></label> <br/>
        <input type="text" style="height: 20%;" placeholder="Enter details of the accussed" name="descr" required> <br/> <br/>

        <label for="desc"><b>Station ID</b></label>
        <select name="stationId">
          <?php
            // $sql = "select StationId from Station;";
            // $result = $conn->query($sql);
            // $count = 0;
            // while($row = $result->fetch_assoc()) {
            //   echo "<option value='v" . $count . "'>" . $row['StationId'] . "</option>";
            //   $count = $count + 1;
            // }
           ?>
        </select> <br/>

        <button type="submit">File FIR</button>
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
      </tr>
      <?php
      // $sql = "select * from FIR where Username = " . $_SESSION['username'] . ";";
      // $result = $conn->query($sql);
      // if ($result->num_rows > 0) {
      //   while( $row = $result->fetch_assoc() ){
      //     echo "<tr>";
      //     echo "<td>".$row['FireID']."</td>";
      //     echo "<td>".$row['LodgeDate']."</td>";
      //     echo "<td>".$row['Descr']."</td>";
      //     echo "<td>".$row['StationId']."</td>";
      //     echo "<td>".$row['Status']."</td>";
      //     echo "</tr>";
      //   }
        ?>
    </table>
  </div>

  <?php
    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //   $username = $_SESSION['username'];
    //   $descr = $_REQUEST['ocr'] . $_REQUEST['descr'];
    //   $stationid = $_REQUEST['stationid']
    //   $sql = "select AadhaarID from User where Username ='" . $username . "';";
    //   $result = $conn->query($sql);
    //   if ($result->num_rows > 0) {
    //     while( $row = $result->fetch_assoc() ){
    //       $userid = $row['AadhaarID'];
    //     }
    //   }
    //   $sql = "select count(*) as total from FIR;";
    //   $result = $conn->query($sql);
    //   if ($result->num_rows > 0){
    //     while( $row = $result->fetch_assoc() ){
    //       $firid = 1 + $row['total'];
    //     }
    //   }
    //   $sql = "insert into FIR (FirId, Lodger, Descr, StationID) values (" . $firid . "," . $username . "," $descr . "," . $stationid . ");";
    //   if (!mysqli_query($con,$sql)){
    //     echo("Error description: " . mysqli_error($con));
    //   }
    // }
  ?>

  </body>
  </html>
