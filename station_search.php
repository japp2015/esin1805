<!DOCTYPE html>
<html lang="en-US">

<head>
<?php 
session_start();
if (!isset($_SESSION['username'])){
    die("Página Privada");
}
$username=$_SESSION['username'];
?>
</head>

<?php include_once('common/header_aside.php'); ?>
<body>
<h1>Pesquisa de Esquadra</h1>

<form action="station_search_result.php" method="post">
    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
    <label>Nome:<input type="text" name="name"></label><br>
    <label>Cidade:<input type="text" name="city"></label><br>
    <input type="submit" value="Pesquisar">
</form>
</body>

<?php include_once('common/footer.php'); ?>
</html>