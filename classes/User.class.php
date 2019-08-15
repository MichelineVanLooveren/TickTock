<?php

require_once __DIR__.'/Db.class.php';

 class User extends DAO
 {
     protected $id;
     protected $user_voornaam;
     protected $user_achternaam;
     protected $email;
     protected $paswoord;
     protected $isAdmin; //niet zeker of dit ook in register moet aangezien admin logingegevens krijgt

     //GETTERS & SETTERS

     /**
      * Get the value of user_voornaam.
      */
     public function getUser_voornaam()
     {
         return $this->user_voornaam;
     }

     /**
      * Set the value of user_voornaam.
      *
      * @return  self
      */
     public function setUser_voornaam($user_voornaam)
     {
         if (!Security::isNotEmpty($user_voornaam)) {
             throw new Exception('Vul je voornaam in');
         }
         $this->user_voornaam = $user_voornaam;

         return $this;
     }

     /**
      * Get the value of user_achternaam.
      */
     public function getUser_achternaam()
     {
         return $this->user_achternaam;
     }

     /**
      * Set the value of user_achternaam.
      *
      * @return  self
      */
     public function setUser_achternaam($user_achternaam)
     {
         if (!Security::isNotEmpty($user_achternaam)) {
             throw new Exception('Vul je achternaam in');
         }
         $this->user_achternaam = $user_achternaam;

         return $this;
     }

     /**
      * Get the value of email.
      */
     public function getEmail()
     {
         return $this->email;
     }

     /**
      * Set the value of email.
      *
      * @return  self
      */
     public function setEmail($email)
     {
         if (!Security::isNotEmpty($email)) {
             throw new Exception('Vul een e-mailadres in');
         }

         Security::isEmailValid($email);

         $this->email = $email;
     }

     /**
      * Get the value of paswoord.
      */
     public function getPaswoord()
     {
         return $this->paswoord;
     }

     /**
      * Set the value of paswoord.
      *
      * @return  self
      */
     public function setPaswoord($paswoord)
     {
         if (!Security::isNotEmpty($paswoord)) {
             throw new Exception('Vul een wachtwoord in');
         }
         Security::isPasswordValid($paswoord);

         $this->paswoord = $paswoord;

         return $this;
     }

     /**
      * Get the value of isAdmin.
      */
     public function getIsAdmin()
     {
         return $this->isAdmin;
     }

     /**
      * Set the value of isAdmin.
      *
      * @return  self
      */
     public function setIsAdmin($isAdmin)
     {
         $this->isAdmin = $isAdmin;

         return $this;
     }

     /**
      * Get the value of id.
      */
     public function getId()
     {
         return $this->id;
     }

     /**
      * Set the value of id.
      *
      * @return  self
      */
     public function setId($id)
     {
         $this->id = $id;

         return $this;
     }

     //FUNCTIES
     //functie om een user te laten registreren --> beveiliging via bcrypt via password_hash()
     public function register($paswoord, $paswoordBevestigen)
     {
         if (!Security::isNotEmpty($paswoordBevestigen)) {
             throw new Exception('Password confirmation cannot be empty.');
         }

         Security::checkForPasswordMatch($paswoord, $paswoordBevestigen);

         $options = [
            'cost' => 12,
        ];

         $paswoord = password_hash($paswoord, PASSWORD_DEFAULT, $options);
         $this->setPassword($paswoord);

         $conn = Db::getInstance();
         $statement = $conn->prepare('INSERT INTO users (email, fullName, username, password) VALUES (:email, :name, :username, :password);');
         $statement->bindValue(':email', $this->getEmail());
         $statement->bindValue(':name', $this->getName());
         $statement->bindValue(':username', $this->getUsername());
         $statement->bindValue(':password', $this->getPassword());

         if (!$statement->execute()) {
             throw new Exception('Oeps, er ging iets mis tijdens de registratie!');
         } else {
             $statement = $conn->prepare('SELECT id FROM users WHERE email = :email ;');
             $statement->bindValue(':email', $this->getEmail());
             $statement->execute();
             $result = $statement->fetch(PDO::FETCH_ASSOC);

             $_SESSION['email'] = $this->getEmail();
             $_SESSION['fullName'] = $this->getName();
             $_SESSION['username'] = $this->getUsername();

             $this->setId($result['id']);
             $this->login();
         }
     }
 }
