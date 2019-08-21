<?php

require_once __DIR__.'/Db.class.php';

 class Lijst extends DAO // klasse Db overerven
 {
     // functie om lijsten uit db te halen
     public function selectAll()
     {
         $sql = 'SELECT * FROM `lijsten`';
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute();

         return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public function selectAllFromUser($userId)
     {
         $sql = 'SELECT * FROM `lijsten` WHERE userId = ' . $userId;
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute();

         return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     // lijsten met taken kunnen connecteren (zodat je lijsten apart kunt bekijken)
     public function selectById($id)
     {
         $sql = 'SELECT * FROM `lijsten` WHERE `id`= :id';
         $stmt = $this->pdo->prepare($sql);
         $stmt->bindValue(':id', $id);
         $stmt->execute();

         return $stmt->fetch(PDO::FETCH_ASSOC);
     }

     // delete lijsten
     public function delete($id)
     {
         $sql = 'DELETE FROM `lijsten` WHERE `id` = :id';
         $stmt = $this->pdo->prepare($sql);
         $stmt->bindValue(':id', $id);

         return $stmt->execute();
     }

     // lijst toevoegen --> id gebruiken om laatste id te weten
     public function insert($data)
     {
         $errors = $this->validate($data);
         if (empty($errors)) {
             $sql = 'INSERT INTO `lijsten` (`title`, `userId`) VALUES (:title, :userId)';
             $stmt = $this->pdo->prepare($sql);
             $stmt->bindValue(':title', $data['title']);
             $stmt->bindValue(':userId', $_SESSION["User"]["userId"]);
             if ($stmt->execute()) {
                 return $this->selectById($this->pdo->lastInsertId());
             }
         }

         return false;
     }

     // checken of alle velden ingevuld zijn
     public function validate($data)
     {
         $errors = [];
         if (empty($data['title'])) {
             $errors['title'] = 'Gelieve een titel in te vullen';
         }

         return $errors;
     }
 }
