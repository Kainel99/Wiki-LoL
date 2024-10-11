<?php

class User {
    private ?int $id;
    private string $username;
    private string $email;
    private string $password;
    private Region $region;
    private Role $role;

    public function __construct(string $username, string $email, string $password, Region $region, Role $role) {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->region = $region;
        $this->role = $role;
    }

    // Getters et setters
    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function setUsername(string $username): void {
        $this->username = $username;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function getRegion(): Region {
        return $this->region;
    }

    public function setRegion(Region $region): void {
        $this->region = $region;
    }

    public function getRole(): Role {
        return $this->role;
    }

    public function setRole(Role $role): void {
        $this->role = $role;
    }
}
