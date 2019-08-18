<?php

require_once __DIR__.'/Db.class.php';

 class Admin extends DAO
 {
     // extends voor overerven voor te connecteren met db
     // functie om alle lijsten te tellen
     public function selectAllLijsten()
     {
         $sql = 'SELECT count(*) as `lijsten` FROM `lijsten`';
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute();

         return $stmt->fetch(PDO::FETCH_ASSOC); //fetch en niet fetchAll omdat er maar 1 resultaat teruggegeven wordt
     }

     // functie om zowel studenten als admins te tellen
     public function selectAllUsersTotaal()
     {
         $sql = 'SELECT count(*) as ` userTotaal` FROM `users`';
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute();

         return $stmt->fetch(PDO::FETCH_ASSOC);
     }

     // functie om aantal studenten te tellen
     public function selectAllUsers()
     {
         $sql = 'SELECT count(*) as `users` FROM `users` WHERE `isAdmin` = 0';
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute();

         return $stmt->fetch(PDO::FETCH_ASSOC);
     }

     // functie om aantal admins tellen
     public function selectAllAdmins()
     {
         $sql = 'SELECT count(*) as `admins` FROM `users` WHERE `isAdmin` = 1';
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute();

         return $stmt->fetch(PDO::FETCH_ASSOC);
     }

     // kijken wat laatste id is, zodat AI altijd eentje meer kan tellen
     public function selectById($id)
     {
         $sql = 'SELECT * FROM `users` WHERE `id` = :id';
         $stmt = $this->pdo->prepare($sql);
         $stmt->bindValue(':id', $id);
         $stmt->execute();

         return $stmt->fetch(PDO::FETCH_ASSOC);
     }

     // functie om alle info over admins uit te lezen
     public function selectAllAdminInfo()
     {
         $sql = 'SELECT * FROM `users` WHERE `isAdmin` = 1';
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute();

         return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     // functie om nieuwe admin aan te maken
     public function insertadmin($data)
     {
         $errors = $this->validate($data);
         if (empty($errors)) {
             $sql = 'INSERT INTO `users` (`user_voornaam`, `user_achternaam`, `email`, `paswoord`, `isAdmin`) VALUES (:user_voornaam, :user_achternaam, :email, :paswoord, :isAdmin)';
             $stmt = $this->pdo->prepare($sql);
             $stmt->bindValue(':user_voornaam', $data['user_voornaam']);
             $stmt->bindValue(':user_achternaam', $data['user_achternaam']);
             $stmt->bindValue(':email', $data['email']);
             $stmt->bindValue(':paswoord', $data['paswoord']);
             $stmt->bindValue(':isAdmin', $data['isAdmin']);
             if ($stmt->execute()) {
                 return $this->selectById($this->pdo->lastInsertId()); //kijken naar laatste id
             }
         }

         return false;
     }

     // functie om admin te verwijderen
     public function delete($id)
     {
         $sql = 'DELETE FROM `users` WHERE `id` = :id';
         $stmt = $this->pdo->prepare($sql);
         $stmt->bindValue(':id', $id);

         return $stmt->execute();
     }

     // foutboodschappen bij aanmaak admin
     public function validate($data)
     {
         $errors = [];
         if (empty($data['user_voornaam'])) {
             $errors['user_voornaam'] = 'Gelieve een user_voornaam in te vullen';
         }
         if (empty($data['user_achternaam'])) {
             $errors['user_achternaam'] = 'Gelieve user_achternaam in te vullen';
         }
         if (empty($data['email'])) {
             $errors['email'] = 'Gelieve email in te vullen';
         }
         if (empty($data['paswoord'])) {
             $errors['paswoord'] = 'Gelieve paswoord in te vullen';
         }

         return $errors;
     }
 }
