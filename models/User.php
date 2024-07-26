<?php

class User 
{
    private ?int $id=null;
    

    public function __construct(private string $username, private string $email, private string $password, private Region $region, private Role $role)
    {
        
    }

    public function getId() :?int
    {
        return $this->id;
    }
    
     public function setId($id) :void
    {
        $this->id = $id;
    }

    public function getUsername() :string
    {
        return $this->username;
    }
    
    public function setUsername($username) :void
    {
        $this->username = $username;
    }

    public function getEmail() :string
    {
        return $this->email;
    }
    
    public function setEmail($email) :void
    {
        $this->email = $email;
    }

    public function getPassword() :string
    {
        return $this->password;
    }

    public function setPassword($password) :void
    {
        $this->password = $password;
    }

    public function getRegion() :Region
    {
        return $this->region;
    }
    
    public function setRegion($region) :void
    {
        $this->region = $region;
    }

    public function getRole() :Role
    {
        return $this->role;
    }
    
    public function setRole($role) :void
    {
        $this->role = $role;
    }

    
}