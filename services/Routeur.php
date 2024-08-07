<?php

class Routeur {
    
    private DefaultController $dc;
    
    public function __construct() {
        $this-> dc = new DefaultController();
    }

    public function handleRequest(? string $route) : void {
        if($route === null)
        {
            $this->dc->homepage();
        }
        else
        {
            $this->dc->notFound();
        }
    }
}
