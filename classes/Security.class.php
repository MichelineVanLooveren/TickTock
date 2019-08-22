<?php
    // nog niet toegepast in voorlopige versie
    class Security extends DAO
    {
        public $paswoord;
        public $paswoordConfirmatie;
        public $email;

        // checken of wachtwoorden voldoen aan registratieprocedure
        public function passwordsAreSecure()
        {
            if ($this->passwordIsStrongEnough()
                && $this->passwordsAreEqual()) {
                return true;
            } else {
                return false;
            }
        }

        // checken of wachtwoord meer dan 8 karakters heeft
        private function passwordIsStrongEnough()
        {
            if (strlen($this->paswoord) <= 8) {
                return false;
            } else {
                return true;
            }
        }

        // checken of opgegeven wachtwoorden overeen komen
        private function passwordsAreEqual()
        {
            if ($this->paswoord == $this->paswoordConfirmatie) {
                return true;
            } else {
                return false;
                throw new Exception('De opgegeven wachtwoorden komen niet overeen.');
            }
        }

        // checken of opgegeven e-mailadres geldig is
        public static function isEmailValid($email)
        {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Gebruik een geldig e-mailadres om te registreren.');
            } else {
                return true;
            }
        }

        // checken of er al een account gekoppeld is aan een het opgegeven e-mailadres
        public function checkIfEmailAlreadyExists($email)
        {
            $conn = Db::getInstance();
            $statement = $conn->prepare('SELECT * from users where email = :email');
            $statement->bindParam(':email', $email);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if (empty($result)) {
                return false; // dit e-mailadres is nog niet gekend
            } else {
                return true; // dit e-mailadres is wel gekend
            }
        }
    }
