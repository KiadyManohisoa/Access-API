<?php

    namespace App\Exception\Mail;

    use Exception;

    class MailIntrouvableException extends Exception
    {
        private string $emailInvalide ;

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
            parent::__construct($this->message, 0, null);
        }
    } 

?>
