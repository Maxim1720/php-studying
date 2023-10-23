<?php
include("user.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = new User($_POST["name"], $_POST["mail"], $_POST["password"]);
    if (UserValidator::validate($user)) {
        $user->setPassword(
            password_hash($user->getPassword(), PASSWORD_DEFAULT)
        );
        $userRegistrer = createRegistrer();
        $user = $userRegistrer->register($user);
        
        echo "User succefully registered!!";
        echo "".$user;
    }
    else{
        echo var_dump(UserValidator::getErrors());
    }
} else {
    echo "Expected post method with name, email, password";
}

function createRegistrer() : UserRegistrer
{
    return new UserRegistrer("registration:5432", "postgres", "postgres", "users");
}

?>