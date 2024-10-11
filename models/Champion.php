<?php 

class Champion 
{
    private $apiUrl = "https://ddragon.leagueoflegends.com/cdn/<version>/data/en_US/champion.json";

    public function getAllChampions() {
        $url = $this->apiUrl;
        $response = file_get_contents($url);
        return json_decode($response, true);  // Retourner les données sous forme de tableau associatif
    }

    public function getChampionById($championId) {
        $url = "https://ddragon.leagueoflegends.com/cdn/<version>/data/en_US/champion/$championId.json";
        $response = file_get_contents($url);
        return json_decode($response, true);
    }
}