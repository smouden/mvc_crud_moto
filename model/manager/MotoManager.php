<?php
class MotoManager extends Database
{

    // Récupérer toutes les motos de la base de données
    public function getAll()
    {
        try {
            // requête SQL pour sélectionner toutes les motos
            $request = $this->db->prepare('SELECT * FROM moto');
            $request->execute();
            $result = $request->fetchAll();

            // Convertir le résultat en tableau d'objets Moto
            $arrayMoto = $this->arrayResultToArrayObject($result);
            return $arrayMoto;
        } catch (\PDOException $e) {
            // j'ai utilisé catch pour faire une  l'exception si une erreur se produit
            throw $e;
        }
    }

    // Récupérer les motos triées par type
    public function motoByType()
    {
        try {
            $motos = [];
            // Préparer et exécuter une requête pour sélectionner les motos triées par type
            $request = $this->db->prepare('SELECT * FROM moto ORDER BY type ASC');
            $request->execute();
            $result = $request->fetchAll();

            // Créer des objets Moto pour chaque élément de résultat
            foreach ($result as $elem) {
                $motos[] = new Moto($elem['brand'], $elem['modele'], $elem['image'], $elem['type'], $elem['idMoto']);
            }
            return $motos;
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    // Récupérer une moto spécifique par son ID
    public function getOne($id)
    {
        $moto = null;
        // Préparer et exécuter une requête pour sélectionner une moto par son ID
        $request = $this->db->prepare('SELECT * FROM moto WHERE idMoto = :idMoto');
        $request->execute(['idMoto' => $id]);
        $result = $request->fetch();
        // Si un résultat est trouvé, créer un objet Moto
        if ($result) {
            $moto = new Moto($result['brand'], $result['modele'], $result['image'], $result['type'], $result['idMoto']);
        }
        return $moto;
    }

    // Récupérer une moto spécifique par son modèle
    public function getByModele($modele)
    {
        $moto = null;
        // Préparer et exécuter une requête pour sélectionner une moto par son modèle
        $request = $this->db->prepare('SELECT * FROM moto WHERE modele = :modele');
        $request->execute(['modele' => $modele]);
        $result = $request->fetch();
        // Si un résultat est trouvé, créer un objet Moto
        if ($result) {
            $moto = new Moto($result['brand'], $result['modele'], $result['type'], $result['image'], $result['idMoto']);
        }
        return $moto;
    }

    // Supprimer une moto de la base de données
    public function delete(Moto $moto)
    {
        try {
            // Préparer et exécuter une requête pour supprimer une moto par son ID
            $request = $this->db->prepare('DELETE FROM moto WHERE idMoto = :idMoto');
            $request->execute(['idMoto' => $moto->getIdMoto()]);
        } catch (\PDOException $e) {
            // Gérer l'exception si une erreur se produit
            throw $e;
        }
    }

    // Ajouter une nouvelle moto à la base de données
    public function add(Moto $moto)
    {
        try {
            // Préparer et exécuter une requête pour insérer une nouvelle moto
            $request = $this->db->prepare('INSERT INTO moto (brand, modele, image, type) VALUES (:brand, :modele, :image, :type)');
            $request->execute([
                'brand' => $moto->getBrand(),
                'modele' => $moto->getModele(),
                'image' => $moto->getImage(),
                'type' => $moto->getType()
            ]);
        } catch (\PDOException $e) {
            // Gérer l'exception si une erreur se produit
            throw $e;
        }
    }

    // Convertir un tableau de tableaux en un tableau d'objets Moto
    public function arrayResultToArrayObject($arrayOfArray)
    {
        $arrayMoto = [];
        // Pour chaque élément du tableau, créer un objet Moto
        foreach ($arrayOfArray as $elem) {
            $arrayMoto[] = new Moto($elem['brand'], $elem['modele'], $elem['image'], $elem['type'], $elem['idMoto']);
        }
        return $arrayMoto;
    }
}

?>