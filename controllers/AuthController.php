<?php

class AuthController extends AbstractController {

    private UserManager $um;
    
    public function __construct() {
        parent::__construct();
        $this->um = new UserManager();
    }
    
    public function register() : void {
        $this->render('front/register.html.twig', []);
    }
    
    public function checkRegister() : void {
    try {
        // Hachage du mot de passe
        $password = password_hash("test", PASSWORD_BCRYPT);
        
        // Création de la région et du rôle
        $regionId = 2; // Assurez-vous que cet ID existe dans la base de données
        $roleId = 1;   // Assurez-vous que cet ID existe dans la base de données
        $region = new Region("West Europe", $regionId);
        $role = new Role("Admin", $roleId);
        
        // Création de l'utilisateur
        $user = new User("toto", "toto@gmail.com", $password, $region, $role);
        
        // Création de l'utilisateur via le UserManager
        $this->um->createUser($user);
        
        // Confirmation ou redirection en cas de succès
        echo "User created successfully.";
    } catch (Exception $e) {
        // Gestion des erreurs
        echo "Error: " . $e->getMessage();
    }
}

    
    public function login() : void  {
        $this->render('front/login.html.twig', []);
    }
    
    public function checkLogin() : void {
        $user = $this->um->findUserByEmail("toto@gmail.com");
        var_dump($user);
    }
    
    public function logout() : void {
        
    }
}