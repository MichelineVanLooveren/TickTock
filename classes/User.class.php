<?php

require_once __DIR__.'/Db.class.php';

 class User extends DAO
 {
     public function selectLogin($email)
     {
         $sql = 'SELECT * FROM `users` WHERE `email` = :email';
         $stmt = $this->pdo->prepare($sql);
         $stmt->bindValue(':email', $email);
         $stmt->execute();

         return $stmt->fetch(PDO::FETCH_ASSOC);
     }

     public function selectById($id)
     {
         $sql = 'SELECT * FROM `users` WHERE `id` = :id';
         $stmt = $this->pdo->prepare($sql);
         $stmt->bindValue(':id', $id);
         $stmt->execute();

         return $stmt->fetch(PDO::FETCH_ASSOC);
     }

     // nieuwe user aanmaken
     public function insertUser($data)
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

     // foutboodschappen bij aanmaak user
     public function validate($data)
     {
         $errors = [];
         if (empty($data['user_voornaam'])) {
             $errors['user_voornaam'] = 'Gelieve uw voornaam in te vullen';
         }
         if (empty($data['user_achternaam'])) {
             $errors['user_achternaam'] = 'Gelieve uw achternaam in te vullen';
         }
         if (empty($data['email'])) {
             $errors['email'] = 'Gelieve uw e-mailadres in te vullen';
         }
         if (empty($data['paswoord'])) {
             $errors['paswoord'] = 'Gelieve een paswoord in te vullen';
         }

         return $errors;
     }
 }
