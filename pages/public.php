<?php 
include_once('../database/connection.php');
$missings = getMissingPeople();
$news = GetNews();
$number_stations=CountNumberOfStations();
?>


   
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Polícia Nacional</title>
    <link href="../css/public_style.css" rel="stylesheet">
    <link href="../css/public_layout.css" rel="stylesheet">
</head>
  
<div class="container">
<header class="header">
    <h2>Polícia Nacional</h2>
    <div class=log_in>
        <button id="log_in_button" type="log_in" onclick="location.href='log_in.php'">Entrar</button>
    </div>
</header>

<aside class="missing">
    <h3>Pessoas desaparecidas</h3>
    <?php if (isset($missings)) { ?>
    <ul>
        <?php foreach($missings as $missing) {
            $nif=$missing['nif'];
            $occurrence = getOccByMissingPerson($nif);
            echo '<li><h4>' . $missing['name'] . '</h4><p>' . $missing['birthdate'] . ' - ' . $missing['physical_description'] . '</p><p>' . $occurrence['location'] . '</p>';
            if (isset($missing['profile_pic'])) { ?>
                <img src="../person_pic/<?=$missing['profile_pic']?>.jpg">
            <?php }
        } ?>
    </ul>
    <footer>
        <p>Tem alguma pista? <a href="contact.php">Contacte-nos!</a></p>
        <p>Reporte um desaparecimento <a href="missing_person_submition.php">aqui</a>.</p>
    </footer>
    <?}?>
</aside>

<body id="public_body">
    <div class="stats">
        <h3> Estatísticas</h3>
        <div id="stats_form">
            <form action="../actions/action_stats.php" method="post">
                <p><select name="station">
                        <option value="geral">Geral</option>
                        <?php $personnel="Detetive";
                        $stations=GetStations();
                        foreach ($stations as $station){?>
                            <option value= <?=$station['id']?>> <?= $station['name'] ?> </option>
                        <?php } ?>          
                </select></p>
                <input type="submit" value="Verificar">
            </form>
        </div>
        <div id="stats_result"> 
            <?php if (!isset($_GET['station']) || $_GET['station']=='geral'){
                echo '<h3>Geral</h3>';
                echo '<p>Casos abertos - ' . CountOccurrencesByState('Aberto')[0] . '</p>';
                echo '<p>Casos fechados - ' . CountOccurrencesByState('Fechado')[0] . '</p>';
                echo '<p>Casos arquivados - ' . CountOccurrencesByState('Arquivado')[0] . '</p>';
            }
            else if ($_GET['station']>0 && $_GET['station']<=$number_stations) {
                $id=$_GET['station'];
                $station=GetStationByID($id);
                echo '<h3>' . $station['name'] . '</h3>';
                echo '<p>Casos abertos - ' . CountOccurrencesByStateAndStation('Aberto', $station)[0] . '</p>';
                echo '<p>Casos fechados - ' . CountOccurrencesByStateAndStation('Fechado', $station)[0] . '</p>';
                echo '<p>Casos arquivados - ' . CountOccurrencesByStateAndStation('Arquivado', $station)[0] . '</p>';
            }
            else {
                echo '<p>Not valid</p>';
            } ?>
        </div>
    </div>
    <div id="line">
        <hr>
    </div>
    <div class="news">
            <h2>Notícias</h2>
            <div id="news_content">
            <?php
            $i = 0;
            foreach($news as $new) {
                echo "<a href='news.php?id=" . $new['id'] . "'>" . "<h4>" . $new['title'] . "</h4></a>";
                echo '<footer>' . $new['date'] . '</footer>';
                echo '<hr>';
                if(++$i > 5) break;
            }
            ?>
        </div>
    </div>

</body>
</div>
<?php include_once('../common/footer.php'); ?>
</html>