<?php

class ChampionController
{
    private ChampionManager $championManager;

    public function __construct(ChampionManager $championManager)
    {
        $this->championManager = $championManager;
    }

    public function importChampions(): void
    {
        try {
            $this->championManager->importChampionsFromApi();
            echo "Champions importés avec succès !";
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}
