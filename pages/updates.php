<?php 
include_once('../database/connection.php');
session_start();
if (!isset($_SESSION['username'])){
    die("Página Privada");
}
$username = $_SESSION['username'];
$user = getUserByUsername($username);

if ($user['position']=='Diretor Nacional'){
    $updates=GetAllUpdates();
}elseif ($user['position']=='Chefe de Esquadra'){
    $updates=GetUpdatesByStation($user['station']);
}elseif ($user['position']=='Detetive'){
    $updates=GetUpdatesByUsernameAndMinorOccurrences($username,$user['station']);
}elseif ($user['position']=='Polícia'){
    $updates=GetUpdatesByUsername($username);
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo 'Atualizações' ?></title>
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/layout_one.css" rel="stylesheet">
</head>

<div class="container">
<?php include_once('../common/header_aside.php'); ?>

<body>
    <div id="left">
    <?php foreach ($updates as $update) { 
        $occurrence=getOccurrenceById($update['id_occurrence'])?>
        <h1> Atualização à ocorrência: <?php echo "<a href='single_occurrence.php?id=" . $occurrence['id'] . "'>" . $occurrence['id'] . " | " . $occurrence['title'] . "</a>" ?> </h1>
            <h3 class="title"> <?=$update['title']?> </h3>
            <p class="text"> <?=$update['text']?> </p>
            <?php $author=getUserByUsername($update['username_personnel']);?>
                <p class="author"><?=$author['position']." ".$author['fullname']?> </p>
    <?php } ?>
    </div> 
</body>

<?php include_once('../common/footer.php'); ?>
    </div>
</html>
