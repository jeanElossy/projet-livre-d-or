<?php 
$title = "Livre d'or";  
require_once 'class/Messages.php';
require_once 'class/GuestBook.php';

$errors = null;
$success = null;

$guestbook = new GuestBook(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'messages.txt');

if(isset($_POST['username']) && isset($_POST['message'])){
    //New message
    $message = new Messages($_POST['username'], $_POST['message']);

    // validation de message
    if($message->isValid()){
        // $success = 'Merci, votre message a bien été posté.';
        $guestbook->addMessage($message);
    }else {
        $errors = $message->getErrors();
    }
}


$messages = $guestbook->getMessages();


require_once 'elements/header.php';
?>


<div>
    <div><h1>Livre d'or</h1></div>
    
    <?php if(!empty($errors)): ?>
        Formulaire incorrect 
    <?php elseif($success): ?>
        <?= $success ?>
    <?php endif ?>

    <form action="" method="post">
        <input type="text" name="username" placeholder="Votre pseudo" class="<?= isset($errors['username']) ? 'is-invalid' : '' ?>"><br>
        <?php if(isset($errors['username'])): ?>
            <div class="invalid-feedback">
                <?= $errors['username'] ?>
            </div>
        <? endif ?>

        <textarea name="message" cols="30" rows="3" placeholder="Votre message" class="<?= isset($errors['message']) ? 'is-invalid' : '' ?>"></textarea><br>
        <?php if(isset($errors['message'])): ?>
            <div class="invalid-feedback">
                <?= $errors['message'] ?>
            </div>
        <? endif ?>

        <button type="submit">Envoyer</button> 
    </form>

    
    <?php if(!empty($messages)): ?>
        <div> <h1>Vos messages:</h1></div>
        <?php foreach($messages as $message): ?>
            <?= $message->toHTML() ?>
        <?php endforeach ?>
    <?php endif ?>
</div>


<?php require_once 'elements/footer.php'?>