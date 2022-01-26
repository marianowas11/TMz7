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
    print "Username: " . $_SESSION['username'];
    ?>
    <br>
    <a href="select.php">Wyślij film</a><br>
    <a href="playlists.php">Tworzenie playlisty i dodawanie filmow</a><br>
    <?php
    $userid=$_SESSION['userid'];
    print "<br><form method=\"post\" action=\"playpl.php\">
    <select name=\"idpl\">";
    print "$userid";
        $playlists = mysqli_query($connection, "Select * from playlistname where idu=$userid ORDER BY name ASC;") or die ("DB error: $dbname 1");
        $playlists2 = mysqli_query($connection, "Select * from playlistname where idu!=$userid AND public=1 ORDER BY name ASC;") or die ("DB error: $dbname 2");
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
    ?>
    <?php echo "<p style=\"color:red;font-size:15px;\">" . $_SESSION['error'] . "</p>";
        $_SESSION['error'] = ""; ?>
    <!-- <form action="upload.php" method="post" enctype="multipart/form-data">
        
        Select file to upload (max 25 MB):<input type="file" name="fileToUpload" id="fileToUpload"><br>
        <input type="submit" value="Upload" name="submit">
    </form> -->
    <?php

    $result = mysqli_query($connection, "Select * from film ORDER BY datetime DESC") or die("DB error: $dbname");
    print "Ostatnio dodane filmy.<br>";
    print "<TABLE CELLPADDING=5 BORDER=1>";
    //print "<TR><TD>Title</TD><TD>Author</TD><TD>Music Player</TD><TD>Lyrics</TD></TR>\n";
    print "<TR><TD>Tytuł</TD><TD>Autor</TD><TD>Odtwarzacz</TD></TR>\n";
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