<?php

class ChampionManager
{
    private PDO $db;
    private RiotApiService $riotApiService;

    public function __construct(PDO $db, RiotApiService $riotApiService)
    {
        $this->db = $db;
        $this->riotApiService = $riotApiService;
    }

    public function importChampionsFromApi(): void
    {
        // Récupération des champions depuis l'API
        $championData = $this->riotApiService->fetchChampions();

        foreach ($championData as $champion) {
            // Mapper les données de l'API en objets Champion et Role
            $championObject = $this->mapChampionData($champion);

            // Insérer chaque champion dans la base
            $this->createChampion($championObject);
        }
    }

    private function mapChampionData(array $apiData): Champion
    {
        $roles = [];
        if (isset($apiData['tags'])) {
            foreach ($apiData['tags'] as $roleName) {
                $roles[] = $this->findOrCreateRole($roleName); // Trouver ou créer le rôle
            }
        }

        return new Champion($apiData['name'], $roles);
    }

    private function findOrCreateRole(string $roleName): Role
    {
        $query = $this->db->prepare("SELECT * FROM roles WHERE name = :name");
        $query->execute(['name' => $roleName]);
        $data = $query->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new Role($data['name'], $data['id']);
        }

        // Si le rôle n'existe pas, l'insérer
        $query = $this->db->prepare("INSERT INTO roles (name) VALUES (:name)");
        $query->execute(['name' => $roleName]);

        return new Role($roleName, $this->db->lastInsertId());
    }

    public function createChampion(Champion $champion): void
    {
        // Insérer le champion dans la table champions
        $query = $this->db->prepare("INSERT INTO champions (name) VALUES (:name)");
        $query->execute(['name' => $champion->getName()]);
        $championId = $this->db->lastInsertId();

        // Insérer les rôles associés
        foreach ($champion->getRoles() as $role) {
            $query = $this->db->prepare("INSERT INTO champion_roles (champion_id, role_id) VALUES (:champion_id, :role_id)");
            $query->execute([
                'champion_id' => $championId,
                'role_id' => $role->getId(),
            ]);
        }
    }
}
