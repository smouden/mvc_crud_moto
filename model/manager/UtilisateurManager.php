<?php

// Définition de la classe UtilisateurManager qui hérite de la classe Database.
class UtilisateurManager extends Database
{

    // findOneByUsername pour trouver un utilisateur par son nom d'utilisateur.
    public function findOneByUsername($username)
    {
        // Préparer une requête SQL pour sélectionner un utilisateur où le nom d'utilisateur correspond au paramètre.
        $request = $this->db->prepare("SELECT * FROM utilisateur WHERE username = :username");

        // Exécuter la requête SQL en passant le nom d'utilisateur comme paramètre.
        $request->execute(['username' => $username]);

        // Récupérer le premier résultat de la requête. 
        // fetch() renvoie une seule ligne de la base de données.
        $result = $request->fetch();

        // Créer et retourner un nouvel objet Utilisateur avec les données récupérées.
        // Ceci crée une instance de la classe Utilisateur en utilisant les valeurs 
        // (username, password, et id) de l'utilisateur trouvé dans la base de données.
        return new Utilisateur($result['username'], $result['password'], $result['id']);
    }
}
?>