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
    background-image: url('./images/history.png');
    background-repeat: no-repeat;
    margin-left: -2%;
  }
  </style>
</head>

<!--  Query Page for normal users. -->
<body>
  <h2 style="margin-left: 40%; margin-top: 3%;">FIR Portal</h2>
  <div style="margin-left: 2%;">
    <div style="margin-top: -3%;"><img src="./images/user.png" alt="Login Avatar" height="15%" width="7%"> <br/> Welcome <?php echo $_SESSION['username'] ?></div>
    <button id="file" onclick="document.getElementById('id02').style.display='block'" style="background-color: red; width: 10%; height: 7%; margin-top: 2%;">File Online FIR</button> </br> <br/>
    <button id="history" onclick="document.getElementById('id03').style.display='block'" style="width: 10%; height: 7%; margin-top: 2%;">View FIR filing history</button> </br> <br/>
    <!-- <button id="history" onclick="document.getElementById('id03').style.display='block'" style="width: 10%; height: 7%; margin-top: 2%;">Withdraw FIR </button> </br> <br/> -->
  </div>

  <div id="fileFIR">
    <form id="id02" action="./query.php" style="width:45%; border-style: solid; border-color: black; padding: 2%; margin-left: 25%; margin-top: -18%; background-color: rgb(0,0,0); background-color: rgba(0,0,0, 0.4); display: none;">

      <label for="uname"><b>UserName</b></label> <br/>
      <input type="text" placeholder="<?php echo $_SESSION['username']; ?>" name="cid" readonly> <br/> <br/>

      <label for="date"><b>Lodged Date</b></label> <br/>
      <input type="text" placeholder="<?php echo date('d-m-Y: h-i-sa'); ?>" name="cid" readonly> <br/> <br/>

      <label for="ocr"><b>Details of occurrence</b></label> <br/>
      <input type="text" style="height: 40%;" placeholder="Enter place, nature of crime and other relevant details" name="ocr" required> <br/> <br/>

      <label for="descr"><b>Description of accussed</b></label> <br/>
      <input type="text" style="height: 20%;" placeholder="Enter details of the accussed" name="descr" required> <br/> <br/>

      <button type="submit">File FIR</button>

      <label for="desc"><b>Station ID</b></label>
      <select name="stationId">
        <?php
          $sql = "select StationId from Station;";
          $result = $conn->query($sql);
          $count = 0;
          while($row = $result->fetch_assoc()) {
            echo "<option value='v" . $count . "'>" . $row['StationId'] . "</option>";
            $count = $count + 1;
          }
         ?>
      </select>

    </form>
  </div>

  <div id="viewFIR">
    <table id="id03" >
      <tr>
        <th>FIR_ID</th>
        <th>Lodged Date</th>
        <th>Description</th>
        <th>StationID</th>
        <th>Status</th>
      </tr>
      <?php
      $sql = "SELECT * FROM (SELECT temp.emp_no, employees.first_name, employees.last_name, employees.gender, temp.from_date, temp.to_date, DATEDIFF(temp.to_date, temp.from_date)as tenure FROM employees INNER JOIN (SELECT dept_emp.*, departments.dept_name FROM dept_emp INNER JOIN departments ON departments.dept_no=dept_emp.dept_no WHERE dept_name=\"$dept\")temp ON temp.emp_no=employees.emp_no)t ORDER BY tenure DESC;";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        while( $row = $result->fetch_assoc() ){
          echo "<tr>";
          echo "<td>".$row['FireID']."</td>";
          echo "<td>".$row['LodgeDate']."</td>";
          echo "<td>".$row['Descr']."</td>";
          echo "<td>".$row['StationId']."</td>";
          echo "<td>".$row['Status']."</td>";
          echo "</tr>";
        }
        ?>
    </table>
  </div>

<?php
  $uname = $_SESSION['username'];
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $descr = $_REQUEST['ocr'] . $_REQUEST['descr'];
    $stationid = $_REQUEST['stationid']
    $sql = "select AadhaarID from User where Username ='" . $username . "';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      while( $row = $result->fetch_assoc() ){
        $userid = $row['AadhaarID'];
      }
    }
    $sql = "select count(*) as total from FIR;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
      while( $row = $result->fetch_assoc() ){
        $firid = 1 + $row['total'];
      }
    }
    $sql = "insert into FIR (FirId, Lodger, Descr, StationID) values (" . $firid . "," . $username . "," $descr . "," . $stationid ");";
    if (!mysqli_query($con,$sql)){
      echo("Error description: " . mysqli_error($con));
    }
  }
?>

</body>
</html>
