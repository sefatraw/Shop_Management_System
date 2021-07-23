<?php
echo 'I am in add_Customer.php page. Ihave to handle username and password here<br>';
$name = $_POST['name'];
$dob = $_POST['dob'];
$location = $_POST['loc'];
$phone = $_POST['phone'];
if(empty($name) || empty($phone))
{
    echo "name/phone cannot be empty!<br>";
}
else
{
    //have to access database and check if this user exists
    //esatblish connection to database and then run a select query
    //we will use PDO - u can use mysqli if u want
    echo 'accessing database to add Customer <br>' ;
    $conn = null;
    $options = [
        PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
    ];
    try {
        // $this->conn = new PDO("mysql:host=" . getenv('DBHOST') . ";dbname=" . getenv('DBNAME') . "", getenv('DBUSER'), getenv('DBPASS'), $options);
        $conn = new PDO("mysql:host=localhost;dbname=appt_b", 'appt_b', '123456', $options);
        echo 'conection to db established <br>';
        //now query for adding Customer
        $stmt = $conn->prepare("insert into Customer (name, dob, location, phone_number) values( :name,:dob,:loc,:phone)");
        $stmt->execute([':name' => $name, ':dob' => $dob, ':loc'=> $location, ':phone'=>$phone]);
        echo "Customer added successfully! <br>";
    } catch (PDOException $exception) {
        throw $exception;
    }
}

?>