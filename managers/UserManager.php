<?php 

class UserManager extends AbstractManager
{
    public function __construct() {
        parent::__construct();
    }
    
    public function createUser(User $user) :User
    {
        $query = "INSERT INTO users (pseudo, email, password, region, role) VALUES (:pseudo, :email, :password, :region, :role)";
        $parameters = [
            "pseudo" => $pseudo,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_DEFAULT),
            "region" => $region,
            "role" => $role
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
    }
    
    public function findUserByEmail(string $email) : ? User
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $parameters = ["email" => $email];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return User;
        }

        return null;
    }
    
    public function getAllUsers()
    {
        $query = "SELECT * FROM users";
        $results = $this->fetchResults($query);

        $users = [];
        foreach ($results as $result) {
            $users[] = $this->mapToUser($result);
        }

        return $users;
    }

    public function updateUser($id, $pseudo, $email, $password, $region, $role)
    {
        $query = "UPDATE users SET pseudo = :pseudo, email = :email, password = :password, region = :region, role = :role WHERE id = :id";
        $parameters = [
            ':pseudo' => $pseudo,
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':region' => $region,
            ':role' => $role,
            ':id' => $id
        ];
        $this->executeQuery($query, $parameters);
    }

    public function deleteUser($id)
    {
        $query = "DELETE FROM users WHERE id = :id";
        $parameters = [':id' => $id];
        $this->executeQuery($query, $parameters);
    }

    private function mapToUser($data)
    {
        $user = new User();
        $user->setId($data['id']);
        $user->setPseudo($data['pseudo']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        $user->setRegion($data['region']);
        $user->setRole($data['role']);

        return $user;
    }
}