<?php
class User
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;

    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
}

class UserValidator
{
    private static $errors = array();
    public static function validate(User $user): bool
    {
        $errors = array();
        UserValidator::checkInputs($user);
        return empty($errors);
    }

    public static function getErrors(): array
    {
        return self::$errors;
    }

    private static function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private static function fieldsNotEmpty(array $fields)
    {
        foreach ($fields as $val) {
            if (empty($val)) {
                return false;
            }
        }
        return true;
    }

    private static function checkInputs(User $user)
    {
        $name = $user->getName();
        $email = $user->getEmail();
        $password = $user->getPassword();

        $fields = [$name, $email, $password];
        if (!UserValidator::fieldsNotEmpty($fields)) {
            array_push($errors, "All fields must be filled!!!");
        } else if (!UserValidator::validateEmail($email)) {
            array_push($errors, "Invalid email!");
        }
    }
}

class UserRegistrer
{
    private $host;
    private $username;
    private $password;
    private PDO $db;


    public function __construct($host, $username, $password, $dbname)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->db = new PDO("psql:host=$host;dbname=$dbname", $this->username, $this->password);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    public function register(User $user): User
    {
        $this->db->query("insert into users values(null, {$user->getEmail()}, {$user->getName()}, {$user->getPassword()});", PDO::FETCH_INTO, $user);
        $this->db->commit();
        // $user->setId($this::db->lastInsertId());
        return $user;
    }
}
?>