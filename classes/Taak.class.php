<?php

require_once __DIR__.'/Db.class.php';

 class Taak extends DAO
 {
     //selecteert alles en ordent van klein naar groot --> toggle
     public function selectAllAsc($lijstId)
     {
         $sql = 'SELECT * FROM `taken` WHERE `lijstId` = :lijstId ORDER BY `datum`, `werkuren`';
         $stmt = $this->pdo->prepare($sql);
         $stmt->bindValue(':lijstId', $lijstId);
         $stmt->execute();

         return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     //toggle groot naar klein
     public function selectAllDesc($lijstId)
     {
         $sql = 'SELECT * FROM `taken` WHERE `lijstId` = :lijstId ORDER BY `datum`, `werkuren` DESC';
         $stmt = $this->pdo->prepare($sql);
         $stmt->bindValue(':lijstId', $lijstId);
         $stmt->execute();

         return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     //id voor insert en update
     public function selectById($id)
     {
         $sql = 'SELECT * FROM `taken` WHERE `id` = :id';
         $stmt = $this->pdo->prepare($sql);
         $stmt->bindValue(':id', $id);
         $stmt->execute();

         return $stmt->fetch(PDO::FETCH_ASSOC);
     }

     //taak toevoegen
     public function insert($data)
     {
         $errors = $this->validate($data);
         if (empty($errors)) {
             $sql = 'INSERT INTO `taken` (`titel`, `werkuren`, `datum`, `gedaan`, `file`, `lijstId`) VALUES (:titel, :werkuren, :datum, :gedaan, :file, :lijstId)';
             $stmt = $this->pdo->prepare($sql);
             $stmt->bindValue(':titel', $data['titel']);
             $stmt->bindValue(':werkuren', $data['werkuren']);
             $stmt->bindValue(':datum', $data['datum']);
             $stmt->bindValue(':gedaan', $data['gedaan']);
             $stmt->bindValue(':file', $data['file']);
             $stmt->bindValue(':lijstId', $data['lijstId']);

             if ($stmt->execute()) {
                 return $this->selectById($this->pdo->lastInsertId());
             }
         }

         return false;
     }

     //taak aanpassen
     public function update($data)
     {
         $errors = $this->validate($data);
         if (empty($errors)) {
             $sql = 'UPDATE `taken` SET
            `titel` = :titel,
            `werkuren` = :werkuren,
            `datum` = :datum
            WHERE `id` = :id';
             $stmt = $this->pdo->prepare($sql);
             $stmt->bindValue(':titel', $data['titel']);
             $stmt->bindValue(':werkuren', $data['werkuren']);
             $stmt->bindValue(':datum', $data['datum']);
             $stmt->bindValue(':id', $data['id']);
             if ($stmt->execute()) {
                 return false;
             }
         }

         return false;
     }

     //controle bij insert en update
     public function validate($data)
     {
         $errors = [];
         if (empty($data['titel'])) {
             $errors['titel'] = 'Gelieve een titel in te vullen';
         }
         if (empty($data['werkuren'])) {
             $errors['werkuren'] = 'Gelieve werkuren in te vullen';
         }

         return $errors;
     }
 }