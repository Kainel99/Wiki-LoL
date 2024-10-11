<?php

class RiotApiService
{
    private string $apiUrl = 'https://ddragon.leagueoflegends.com/cdn/12.19.1/data/en_US/champion.json'; // Version Data Dragon

    public function fetchChampions(): array
    {
        $json = file_get_contents($this->apiUrl); // Faire la requête
        if ($json === false) {
            throw new Exception("Erreur lors de la requête à l'API Riot");
        }

        $data = json_decode($json, true);

        // On s'assure que les données sont bien présentes
        if (!isset($data['data'])) {
            throw new Exception("Données invalides reçues de l'API Riot");
        }

        return $data['data'];
    }
}
