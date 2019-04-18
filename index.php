<?php

session_start();
// set error reporting level
if (version_compare(phpversion(), '5.3.0', '>=') == 1)
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
  error_reporting(E_ALL & ~E_NOTICE);

# Initial Declarations
$host = 'mysql';
$user = 'root';
$pass = 'temp';
$db = 'employees';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['submit']))
{
  $p_emp_no = trim(strip_tags($_POST['emp_no']));
  $p_first_name = trim(strip_tags($_POST['first_name']));
  $p_last_name = trim(strip_tags($_POST['last_name']));
  $p_dept = trim(strip_tags($_POST['dept']));
  $p_bday = trim(strip_tags($_POST['bday']));
  $p_gender = trim(strip_tags($_POST['gender']));
  if($p_gender == "male")
    $p_gender = "M";
  else if($p_gender == "female")
    $p_gender = "F";
  else
    $p_gender = "N";

  $query = "select employees.*, dept_emp.dept_no, departments.dept_name, dept_emp.from_date, dept_emp.to_date
    from (((dept_emp
    inner join dept_emp_latest_date on (dept_emp.emp_no = dept_emp_latest_date.emp_no and dept_emp.from_date = dept_emp_latest_date.from_date and dept_emp.to_date = dept_emp_latest_date.to_date))
    inner join departments on dept_emp.dept_no = departments.dept_no)
    inner join employees on dept_emp.emp_no = employees.emp_no)
    where true";

    if(strlen($p_emp_no) != 0)
      $query = $query . " and employees.emp_no=" . $p_emp_no;
    if(strlen($p_first_name) != 0)
      $query = $query . " and first_name=\"" . $p_first_name . "\"";
    if(strlen($p_last_name) != 0)
      $query = $query . " and last_name=\"" . $p_last_name . "\"";
    if(strlen($p_bday) != 0)
      $query = $query . " and birth_date=\"" . $p_bday . "\"";
    if(strlen($p_dept) != 0)
      $query = $query . " and (dept_name=\"" . $p_dept . "\" or departments.dept_no=\"" . $p_dept . "\")";
    if($p_gender != "N")
      $query = $query . " and gender=\"" . $p_gender . "\"";
    $query = $query . ";";
  
  $result = $conn->query($query);
  if($result->num_rows > 0)
  {
    echo "<link href=\"css/main.css\" rel=\"stylesheet\" type=\"text/css\" />";
    echo "<table id=\"employees\" style=\"width:100%\">
      <tr>
        <th>Employee ID </th>
        <th>Name        </th>
        <th>Department  </th>
        <th>Birth Date  </th>
        <th>Gender      </th>
        <th>Hired on    </th>
      </tr>";
    while ($row = $result->fetch_assoc())
    {
      echo "<tr>
        <td>" . $row["emp_no"] . "</td>
        <td>" . $row["first_name"] . " " . $row["last_name"] . "</td>
        <td>" . $row["dept_name"] . "</td>
        <td>" . $row["birth_date"] . "</td>
        <td>" . $row["gender"] . "</td>
        <td>" . $row["hire_date"] . "</td>
        </tr>";
    }
    echo "</table><br>";
    $tempp = $result->num_rows;
    echo "<h2 id=\"results\">Total " . $tempp . " results found</h3><br>";
  }
  else
    echo "<h2 id=\"results\">Total 0 results found</h3><br>";
  $conn->close();
  exit;
}

echo strtr(file_get_contents('templates/main_page.html'), array());

$dept_query = "select departments.dept_name, count(dept_emp.emp_no) as count
    from departments
    inner join dept_emp on (departments.dept_no = dept_emp.dept_no)
    group by departments.dept_name
    order by count desc limit 1;";
$res = $conn->query($dept_query);
$r = $res->fetch_assoc();

echo "<h2 id=\"results\">" . $r["dept_name"] . " is the largest department with " . $r["count"] . " employees.</h3><br>";

?>
