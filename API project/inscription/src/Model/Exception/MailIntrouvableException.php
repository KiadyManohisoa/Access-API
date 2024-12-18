<?php

    namespace App\Model\Exception;

    use Exception;

    class MailIntrouvableException extends Exception
    {
        private string $emailInvalide ;
        private static $code = 0 ;

        public function setEmailInvalide(string $emailInvalide): void{
            $this->emailInvalide = $emailInvalide;
        }

        public function getEmailInvalide(): string{
            return $this->emailInvalide;
        }

        public function __construct(string $message="Mail inexistant", string $emailInvalide)
        {
            $this->message = $message ;
            $this->setEmailInvalide($emailInvalide);
            parent::__construct($this->message, $this->code, null);
        }
    } 

?>
