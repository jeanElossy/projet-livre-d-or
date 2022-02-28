<?php
class Messages {

    const LIMIT_USERNAME = 3;
    const LIMIT_MESSAGE = 10;
    private $username;
    private $message;
    private $date;

    public function __construct (string $username, string $message, ?DateTime $date = null)
    {
        $this->username = $username;
        $this->message = $message;
        $this->date = $date ?: new DateTime();
    }

    // methode de verification et validation de message 
    public function isValid(): bool 
    {
        return empty($this->getErrors());
    }

    // methode de gestion des erreurs 
    public function getErrors(): array
    {
        $errors = [];
        if(strlen($this->username) < self::LIMIT_USERNAME){
            $errors['username'] = 'Votre pseudo est trop court';
        }
        if(strlen($this->message) < self::LIMIT_MESSAGE){
            $errors['message'] = 'Votre message est trop court';
        }
        return $errors;
    }

    // methode de conversion du message en string 
    public function toJSON(): string
    {
        return json_encode([
            'username' => $this->username,
            'message' => $this->message,
            'date' => $this->date->getTimestamp()
        ]);
    }

    // methode de conversion du message en html
    public function toHTML(): string
    {
        $username = htmlentities($this->username);
        $message = htmlentities($this->message);
        $date = $this->date->format('d/m/y à H:i');
        return <<<HTML
        <p>
            <strong>{$username}</strong> <em>Le {$date}</em><br />
            {$message}
        </p>
HTML;
    }

}

?> 