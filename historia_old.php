<?php
//header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', '1');
session_start(); //start sesji 
ob_start();

?>

    <html xmlns="http://www.w3.org/1999/xhtml" lang="pl">
    <head>
        <title>Historia Przelewów | SamoŻycie |</title>
        <?php include('inc/dane_head.php'); ?>
    </head>

    <body>
    <?php
    include('connect.php');
    include('inc/menu.php');

    if (empty($_SESSION['login'])) {
        header("Location: login.php");
    }
    ?>

    <div class="main-content">

        <div class="header">
            <div class="header-big">Historia Transakcji</div>
            <div class="header-small">Tutaj sprawdzisz swoje ostatnie przelewy.</div>
        </div>
        <?php
        $ranga = mysql_query("SELECT * FROM user WHERE login='" . $_SESSION['login'] . "'");
        $wynik = mysql_fetch_array($ranga);
        ?>

        <div class="title">
            Twoje Dochody.
        </div>
        <div class="tablediv">
            <table class="table">
                <thead>
                <tr class="viphistoria">
                    <th>Od</th>
                    <th>Tytuł Przelewu</th>
                    <th>IK</th>
                    <th>Data</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $lista2 = mysql_query("SELECT * FROM `zgloszenia` WHERE login='" . $_SESSION['login'] . "'") or die(mysql_error());
                $ile = mysql_num_rows($lista2);


                if ($ile < 1) {
                    echo '<tr>';
                    echo '<td>Brak akcji dochodowych!</td>';
                    echo '</tr>';
                } else {
                    $lista = mysql_query("SELECT * FROM `zgloszenia` WHERE login='" . $_SESSION['login'] . "' ORDER BY `id` DESC LIMIT 35") or die(mysql_error());
                    while ($row = mysql_fetch_row($lista)) {
                        $vipdochody = mysql_query("SELECT * FROM user WHERE login='" . $row[4] . "'");
                        $vipd = mysql_fetch_array($vipdochody);


                        if ($row[4] == "System") //Przelew System
                        {
                            echo '<tr class="success">';
                            echo '<td><i class="fas fa-users-cog" style="color: #870120;"></i> <span class="lg-b">' . $row[4] . '</span></td>';
                            echo '<td><span class="vip">' . $row[7] . '</span></td>';
                            echo '<td><span class="vip">' . $row[6] . ' <img src="icon.png" width="16" height="16" /></span></td>';
                            echo '<td><span class="vip">' . $row[2] . '</span></td>';
                            echo '</tr>';
                        } else
                            if ($row[4] == "Admin") //Przelew Panel Admina
                            {
                                echo '<tr class="success">';
                                echo '<td><i class="fas fa-users-cog" style="color: #870120;"></i> <span class="lg-b">' . $row[4] . '</span></td>';
                                echo '<td><span class="vip">' . $row[7] . '</span></td>';
                                echo '<td><span class="vip">' . $row[6] . ' <img src="icon.png" width="16" height="16" /></span></td>';
                                echo '<td><span class="vip">' . $row[2] . '</span></td>';
                                echo '</tr>';
                            } else
                                if ($vipd['ranga'] == 1) //Sprawdzanie VIP
                                {
                                    echo '<tr bgcolor="' . $vipd['kolor'] . '">';
                                    echo '<td><img src="vip.gif" alt="UZYTKOWNIK VIP"> <span class="vip">' . $row[4] . '</span></td>';
                                    echo '<td><span class="vip">' . $row[7] . '</span></td>';
                                    echo '<td><span class="vip">' . $row[6] . ' <img src="icon.png" width="16" height="16" /></span></td>';
                                    echo '<td><span class="vip">' . $row[2] . '</span></td>';
                                    echo '</tr>';
                                } else
                                    if ($vipd['ranga'] >= 2) //Sprawdzanie ASYSTENT
                                    {
                                        echo '<tr class="success">';
                                        echo '<td><i class="fas fa-user-cog" style="color: #870120;"></i> <span class="lg-b">' . $row[4] . '</span></td>';
                                        echo '<td><span class="vip">' . $row[7] . '</span></td>';
                                        echo '<td><span class="vip">' . $row[6] . ' <img src="icon.png" width="16" height="16" /></span></td>';
                                        echo '<td><span class="vip">' . $row[2] . '</span></td>';
                                        echo '</tr>';
                                    } else //ZWYKLY USER
                                    {
                                        echo '<tr class="success">';
                                        echo '<td><i class="fa fa-user-tie"></i> ' . $row[4] . '</td>';
                                        echo '<td>' . $row[7] . '</td>';
                                        echo '<td><b>' . $row[6] . ' <img src="icon.png" width="16" height="16" /></b></td>';
                                        echo '<td>' . $row[2] . '</td>';
                                        echo '</tr>';
                                    }
                    }
                }

                ?>
                </tbody>
            </table>
        </div>
        <div class="title">
            Twoje Wydatki.
        </div>

        <?php
        $akcje = mysql_query("SELECT * FROM user WHERE login='" . $_SESSION['login'] . "'");
        $lista = mysql_fetch_array($zapytanie);
        ?>
        <div class="tablediv">
            <table class="table">
                <thead>
                <tr class="viphistoria">
                    <th>Do</th>
                    <th>Tytuł Przelewu</th>
                    <th>IK</th>
                    <th>Data</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $lista2 = mysql_query("SELECT * FROM `zgloszenia` WHERE od='" . $_SESSION['login'] . "'") or die(mysql_error());
                $ile = mysql_num_rows($lista2);

                if ($ile < 1) {
                    echo '<tr>';
                    echo '<td>Brak akcji wydatkowych!</td>';
                    echo '</tr>';
                } else {
                    $lista = mysql_query("SELECT * FROM `zgloszenia` WHERE od='" . $_SESSION['login'] . "' ORDER BY `id` DESC LIMIT 15") or die(mysql_error());
                    while ($row = mysql_fetch_row($lista)) {
                        $vipwydatki = mysql_query("SELECT * FROM user WHERE login='" . $row[1] . "'");
                        $vipw = mysql_fetch_array($vipwydatki);

                        if ($row[1] == "Admin") {
                            echo '<tr class="danger">';
                            echo '<td><i class="fas fa-users-cog" style="color: #870120;"></i> <span class="lg-b">' . $row[1] . '</span></td>';
                            echo '<td><span class="vip">' . $row[7] . '</span></td>';
                            echo '<td><span class="vip">' . $row[6] . ' <img src="icon.png" width="16" height="16" /></span></td>';
                            echo '<td><span class="vip">' . $row[2] . '</span></td>';
                            echo '</tr>';
                        } else
                            if ($vipw['ranga'] == 1) {
                                echo '<tr bgcolor="' . $vipw['kolor'] . '">';
                                echo '<td><span class="vip"><img src="vip.gif" alt="UZYTKOWNIK VIP"> ' . $row[1] . '</span></td>';
                                echo '<td><span class="vip">' . $row[7] . '</span></td>';
                                echo '<td><span class="vip">' . $row[6] . ' <img src="icon.png" width="16" height="16" /></span></td>';
                                echo '<td><span class="vip">' . $row[2] . '</span></td>';
                                echo '</tr>';
                            } else
                                if ($vipw['ranga'] >= 2) {
                                    echo '<tr class="danger">';
                                    echo '<td><i class="fas fa-user-cog" style="color: #870120;"></i> <span class="lg-b"> ' . $row[1] . '</span></td>';
                                    echo '<td><span class="vip">' . $row[7] . '</span></td>';
                                    echo '<td><span class="vip">' . $row[6] . ' <img src="icon.png" width="16" height="16" /></span></td>';
                                    echo '<td><span class="vip">' . $row[2] . '</span></td>';
                                    echo '</tr>';
                                } else {
                                    echo '<tr class="danger">';
                                    echo '<td><i class="fa fa-user-tie"></i> ' . $row[1] . '</td>';
                                    echo '<td>' . $row[7] . '</td>';
                                    echo '<td><b>' . $row[6] . ' <img src="icon.png" width="16" height="16" /></b></td>';
                                    echo '<td>' . $row[2] . '</td>';
                                    echo '</tr>';
                                }
                    }
                }

                ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- KONIEC CONTAINER-->


    <?php include('inc/footer.php'); ?>
    </body>
    </html>

<?php ob_end_flush(); ?>