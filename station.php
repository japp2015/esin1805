<?php 
include_once('database/connection.php');
session_start();
$station = GetStationByID($_GET['station']);

?>

<!DOCTYPE html>
<html>
<title><?php echo "Esquadra " . $station['name'] ?></title>

<?php include_once('common/header_aside.php'); ?>

<body>
    <div id="station_info">
        <h1> <?php echo $station['name']?> </h1>
        <p> Morada: <?php echo $station['adress'] ?> </p>
        <?php $chief=getUserByUsername($station['chief']) ?>
        <p> Chefe de Esquadra: <?php echo $chief['fullname'] ?> </p>
    </div>
  
    <div id="personnel">
        <h2>Equipa: </h2>
        
        <?php $position="Chefe de Esquadra";
        $Chief=GetPersonnelStation($position,$station["id"])?>
        <h3> Chefe de Esquadra: 
            <?php foreach($Chief as $Chief){ 
                   echo $Chief['fullname']; }?> </h3>
        
        <?php $position="Detetive";
        $detectives=GetPersonnelStation($position,$station["id"])?>
        <p> Detetives: </p>
             <ul>
             <?php foreach($detectives as $detective) { ?>
                    <li> <?php echo $detective['fullname'] ?> </li> 
            <?php } ?>
            </ul>

        <?php $position="Polícia";
        $polices=GetPersonnelStation($position,$station["id"])?> 
        <p> Polícias: </p>
             <ul>
             <?php foreach($polices as $police) { ?>
                    <li> <?php echo $police['fullname'] ?> </li> 
            <?php } ?>
            </ul>
    </div>
</body>
</html>