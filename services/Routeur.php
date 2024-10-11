<?php

class Routeur {
    
    private DefaultController $dc;
    private AuthController $ac;
    
    public function __construct() {
        $this-> dc = new DefaultController();
        $this->ac = new AuthController();
    }

    public function handleRequest(? string $route) : void {
        if($route === null || $route === "home")
        {
            $this->dc->homepage();
        }
        else if ($route === "inscription") 
        {
            $this->ac->register();
        }
        else if ($route === "check-inscription") 
        {
            $this->ac->checkRegister();
        }
        else if ($route === "connexion") 
        {
            $this->ac->login();
        }
        else if ($route === "check-connexion") 
        {
            $this->ac->checkLogin();
        }
        else if ($route === "deconnexion") 
        {
            $this->ac->logout();
        }
        else
        {
            $this->dc->notFound();
        }
    }
}
