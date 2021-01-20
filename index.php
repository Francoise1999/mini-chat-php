<?php
// Connexion a la base de donnée
try{
    $db = new PDO("mysql:host=localhost; port=3306; dbname=tuto", "root", "");
} catch(Exception $e){
    die("Erreur de connexion : " . $e->getMessage());
}
if(isset($_POST["pseudo"]) AND isset($_POST["message"]) AND !empty($_POST["pseudo"]) AND !empty($_POST["message"])){
    $pseudo = htmlspecialchars($_POST["pseudo"]);
    $message = htmlspecialchars($_POST["message"]);
    $insertmsg = $db->prepare("INSERT INTO chat(pseudo, message) VALUES(?, ?)");
    $insertmsg->execute([$pseudo, $message]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">  
        <input type="text" name="pseudo" placeholder="PSEUDO" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>"><br>
        <textarea name="message" placeholder="MESSAGE" cols="30" rows="5"></textarea><br>
        <input type="submit" value="Envoyer">
    </form>
    <?php
    $allmsg = $db->query("SELECT * FROM chat ORDER BY id DESC");
    while($msg = $allmsg->fetch()){
    ?>
    <b><?php echo $msg["pseudo"]; ?> : </b><?php echo $msg["message"]; ?><br>
    <?php
    }
    ?>
</body>
</html>