<?php

    class Security
    {
        public $password;
        public $passwordConfirmation;
        public $username;

        //EMAIL
        // checken of correct e-mailadres ingegeven wordt
        public static function isEmailValid($email)
        {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Vul een correct e-mailadres in.');
            } else {
                return true;
            }
        }

        //checken of e-mailadres al gekoppeld is aan bestaand account
        public static function emailExists($email)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare('SELECT * FROM tl_user WHERE email = :email;');
            $statement->bindParam(':email', $email);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if (empty($result)) {
                return false; // dit e-mailadres is nog niet gekoppeld aan een account
            } else {
                return true; // dit e-mailadres is al gekoppeld aan een bestaand account
            }
        }

        //WACHTWOORD
        // checken of wachtwoord 8 of meer karakters heeft
        private function passwordIsStrongEnough()
        {
            if (strlen($this->password) <= 8) {
                return false;
            } else {
                return true;
            }
        }

        // checken of password en passwordConfirmation gelijk zijn
        private function passwordsAreEqual()
        {
            if ($this->password == $this->passwordConfirmation) {
                return true;
            } else {
                return false;
                throw new Exception('De opgegeven paswoorden komen niet overeen.');
            }
        }

        // checken of procedure paswoord klopt dwz voldoet aan bovenstaande voorwaarden
        public function passwordProcess()
        {
            if ($this->passwordIsStrongEnough() && $this->passwordsAreEqual()) {
                return true;
            } else {
                return false;
            }
        }
    }
