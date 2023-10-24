<?php
include("user.php");
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = new User($_POST["name"], $_POST["mail"], $_POST["password"]);
    if (UserValidator::validate($user)) {
        $user->setPassword(
            password_hash($user->getPassword(), PASSWORD_DEFAULT)
        );
        // UserRegistrer $userRegistrer = createRegistrer();
        $userRegistrer = UserRegisterFabric::postgresDbInstance();
        $user = $userRegistrer->register($user);
        
        echo "User succefully registered!!";
        echo $user->__toString();
    }
    else{
        echo var_dump(UserValidator::getErrors());
    }
} else {
    echo "Expected post method with name, email, password";
}



?>