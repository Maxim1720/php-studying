<?php
function fieldsNotEmpty($fields)
{
    foreach ($fields as $val) {
        if (empty($val)) {
            return false;
        }
    }
    return true;
}

function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
function checkInputs()
{
    $name = $_POST["name"];
    $email = $_POST["mail"];
    $password = $_POST["password"];

    $fields = [$name, $email, $password];
    if (!fieldsNotEmpty($fields)) {
        echo "All fields must be filled!!!";
    } else if (!validateEmail($email)) {
        echo "Invalid email!";
    } else {
        echo "Registration sucessfully";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    checkInputs();
} else {
    echo "Expected post method with name, email, password";
}

?>