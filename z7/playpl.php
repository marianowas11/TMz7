<?php

declare(strict_types=1); // włączenie typowania zmiennych w PHP >=7
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">

<HEAD>
<meta charset="UTF-8">
<title>Mariusz Jackowski z6</title>
    </script>
</HEAD>

<BODY>
    <?php
        session_start();
        $dbhost="**"; $dbuser="**"; $dbpassword="**"; $dbname="**";
        $connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
        if (!$connection) {
            echo " MySQL Connection error." . PHP_EOL;
            echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
    session_start(); // zapewnia dostęp do zmienny sesyjnych w danym pliku
    if (!$_SESSION['loggedin'] == "true") {
        $_SESSION['error'] = "Nie zalogowano";
        header('Location: index.php');
        exit();
    }
    echo "<div style=\"position:absolute;right:10px;top:10px;font-size:18px;font-weight:bold;\"><a href=\"logout.php\">Log out</a></div>";
    echo "<div style=\"position:absolute;left:10px;top:10px;font-size:18px;font-weight:bold;\"><a href=\"index2.php\">Powrót</a></div>";
    print "<br><br>";
    print "Username: " . $_SESSION['username'];
    ?>
    <br>

    <?php
    $userid=$_SESSION['userid'];
    print "<br><form method=\"post\" action=\"playpl.php\">
    <select name=\"idpl\">";
        $playlists = mysqli_query($connection, "Select * from playlistname where idu=$userid ORDER BY name ASC;") or die ("DB error: $dbname");
        $playlists2 = mysqli_query($connection, "Select * from playlistname where idu!=$userid AND public=1 ORDER BY name ASC;") or die ("DB error: $dbname");
        while($row = mysqli_fetch_array($playlists)){
            $idpl = $row[0];
            $plname = $row[2];
            print "<option value=\"$idpl\">$plname</option>";
        }
        while($row = mysqli_fetch_array($playlists2)){
            $idpl = $row[0];
            $plname = $row[2];
            print "<option value=\"$idpl\">$plname</option>";
        }
    print "</select>
    <input type=\"submit\" value=\"Odtwórz\"/>
    </form><br>";
        $idpl=$_POST['idpl']; // login z formularza
        //$idpl = htmlentities ($idpl, ENT_QUOTES, "UTF-8");
    echo "<p style=\"color:red;font-size:15px;\">" . $_SESSION['error'] . "</p>";
        $_SESSION['error'] = ""; ?>
        <?php

$zapcos = mysqli_query($connection, "Select idf from playlistdatabase where idpl=$idpl") or die("DB error: $dbname");
$zapplname = mysqli_query($connection, "Select name from playlistname where idpl=$idpl") or die("DB error: $dbname");
$plname = mysqli_fetch_array($zapplname);
$ile=0;$i=0;
while($rowzap = mysqli_fetch_array($zapcos)){
   $wids[$i]=$rowzap[0];
   $i++;
   $ile++;
}
print "Aktualna playlista: $plname[0]<br>";
print "<TABLE CELLPADDING=5 BORDER=1>";
print "<TR><TD>Tytuł</TD><TD>Autor</TD><TD>Odtwarzacz</TD></TR>\n";
for($i=0;$i<$ile;$i++){
    $result = mysqli_query($connection, "Select * from film where idf='$wids[$i]' ORDER BY datetime DESC") or die("DB error: $dbname in");
    while ($row = mysqli_fetch_array($result)) {
        $ids = $row[0];
        $title = $row[1];
        $musician = $row[2];
        $datetime = $row[3];
        $idu = $row[4];
        $filename = $row[5];
        $lyrics = $row[6];
        $idmt = $row[7];
        print "<TR>";
        print "<TD>$title</TD>";
        print "<TD>$musician</TD>";
        print "<TD>";
        print "
        <video controls muted style=\"background:black;min-width:180px;max-width:360px;min-height:180px;max-height:640px;\">
                        <source src=\"songs/" . $filename ."\"type=\"video/mp4\">
                      Your browser does not support the video tag.
                      </video>";
                
        print "</TD>";
        //print "<TD>$lyrics</TD>";
        print "</TR>\n";
    }
        print "</TD>";
        //print "<TD>$lyrics</TD>";
        print "</TR>\n";
    }
print "</TABLE>";
mysqli_close($connection);
?>
<script>
    var aud = document.getElementById("audio");
    aud.volume = 0.2;
    //document.getElementById("audio").play();
</script>
</BODY>

</HTML>