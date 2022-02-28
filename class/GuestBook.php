<?php 
require_once 'Messages.php';

class GuestBook {

    private $file;

    public function __construct (string $file)
    { 
        // le dossier je souhaite sauvegarder le dossier
        $directory = dirname($file);
        // Je verifies si c'est dossier
        if(!is_dir($directory)){
            // si c'est pas un dossier je crée le dossier
            mkdir($directory, 0777, true);
        }
        // et je verifie si le fichier existe
        if(!file_exists($file)){
            // sinon je le crée
            touch($file);
        }

        $this->file = $file;
    }

    // methode d'ajout de message 
    public function addMessage(Messages $message): void
    {
        file_put_contents($this->file, $message->toJSON() . "\n", FILE_APPEND);
    }

    // methode de recupperation et d'affichage de message
    public function getMessages(): array 
    {
        $content = trim(file_get_contents($this->file));
        $lines = explode("\n", $content);
        $messages = [];

        foreach($lines as $line){
            $data = json_decode($line, true);
            $messages[] = new Messages($data['username'], $data['message'], new DateTime("@" . $data['date'])); 
        }
        return array_reverse($messages);
    }
}
?>