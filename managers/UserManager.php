<?php 

class UserManager extends AbstractManager
{
    public function __construct() {
        parent::__construct();
    }
    
    public function createUser(User $user): User
    {
        $pseudo = $user->getUsername();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $regionId = $user->getRegion()->getId();
        $roleId = $user->getRole()->getId();  // Assurez-vous que ceci n'est pas NULL
    
        if ($roleId === null) {
            throw new Exception('Role ID cannot be null');
        }
    
        $query = $this->db->prepare("INSERT INTO users (pseudo, email, password, region_id, role_id) VALUES (:pseudo, :email, :password, :region_id, :role_id)");
    
        $parameters = [
            "pseudo" => $pseudo,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_DEFAULT),
            "region_id" => $regionId,
            "role_id" => $roleId
        ];
    
        $query->execute($parameters);
    
        $user->setId($this->db->lastInsertId());
        return $user;
    }

    
    public function findUserByEmail(string $email) : ?User
    {
        try {
            // Requête SQL avec jointure corrigée
            $query = "SELECT users.id, users.pseudo, users.email, users.password, users.region_id, region.name AS region_name, users.role_id, role.name AS role_name
                      FROM users
                      JOIN region ON users.region_id = region.region_id
                      JOIN role ON users.role_id = role.role_id
                      WHERE users.email = :email";
    
            $stmt = $this->db->prepare($query);
    
            if (!$stmt) {
                throw new Exception("Échec de la préparation de la requête.");
            }
    
            // Lier les paramètres
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
    
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($data) {
                return $this->mapToUser($data);
            } else {
                return null;
            }
    
        } catch (PDOException $e) {
            // Gérer les erreurs PDO
            echo "Erreur PDO : " . $e->getMessage();
            return null;
        } catch (Exception $e) {
            // Gérer toute autre erreur
            echo "Erreur : " . $e->getMessage();
            return null;
        }
    }



    
    public function getAllUsers()
    {
        // Préparer et exécuter la requête
        $query = $this->db->prepare("SELECT * FROM users");
        $query->execute();
    
        // Récupérer tous les résultats
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
    
        // Mapper les résultats en objets User
        $users = [];
        foreach ($results as $result) {
            $users[] = $this->mapToUser($result);
        }
    
        return $users;
    }

    public function updateUser($id, $pseudo, $email, $password, $region, $role)
    {
        // Vérifier si le mot de passe a été modifié
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        } else {
            // Si aucun mot de passe n'est fourni, garder l'ancien mot de passe
            $hashedPassword = $this->getCurrentPasswordForUser($id);
        }

        // Préparer la requête d'update
        $query = "UPDATE users SET pseudo = :pseudo, email = :email, password = :password, region_id = :region_id, role_id = :role_id WHERE id = :id";
        $parameters = [
            ':pseudo' => $pseudo,
            ':email' => $email,
            ':password' => $hashedPassword,
            ':region_id' => $region,
            ':role_id' => $role,
            ':id' => $id
        ];

        // Exécuter la requête
        $stmt = $this->db->prepare($query);
        $stmt->execute($parameters);
    }

    public function deleteUser($id)
    {
        // Préparer la requête de suppression
        $query = "DELETE FROM users WHERE id = :id";
        $parameters = [':id' => $id];

        // Exécuter la requête
        $stmt = $this->db->prepare($query);
        $stmt->execute($parameters);
    }

    private function getCurrentPasswordForUser($id)
    {
        // Récupérer le mot de passe actuel de l'utilisateur
        $query = $this->db->prepare("SELECT password FROM users WHERE id = :id");
        $query->execute([':id' => $id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        return $result['password'];
    }

    private function mapToUser(array $data) : User
    {
        $region = new Region($data['region_name'], $data['region_id']);
        $role = new Role($data['role_name'], $data['role_id']);
    
        $user = new User(
            $data['pseudo'],
            $data['email'],
            $data['password'],
            $region,
            $role
        );
    
        $user->setId($data['id']);
    
        return $user;
    }
}
