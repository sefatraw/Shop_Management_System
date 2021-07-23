<?php
echo 'I am in login.php page. Ihave to handle username and password here<br>';
$username = $_POST['username'];
$pass = $_POST['secret'];
//echo "Username is $username and password is $pass.<br>";
//must sanitize ur input 
//also must check first if the usrname and password empty or not
if(empty($username) || empty($pass))
{
    echo "username/passwor cannot be empty!<br>";
}
else
{
    //have to access database and check if this user exists
    //esatblish connection to database and then run a select query
    //we will use PDO - u can use mysqli if u want
    echo 'accessing database <br>' ;
    echo "USERNAME: $username<br>";
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
        //now query for the user
        $stmt = $conn->prepare("select * from users where username = :username and password = :pass");
        $stmt->execute([':username' => $username, ':pass' => $pass]);
        $row = $stmt->fetchAll();
        if($row)
        {
            echo "User $username is a valid user <br>";
            //redirect to dashboard
            header("Location: index.html");//redirection
        }
        else
        {
            echo 'Invalid user<br>';//      
        }

    } catch (PDOException $exception) {
        throw $exception;
    }
}

?>