<?php
try{
    $stmt = $pdo->query("SELECT login as Opis, Concat(login, ' - ', imie) as Extra FROM user ORDER BY `login`");
    $users_fetch = $stmt->fetchAll();
    $users = array();
    $users_search = array();
    //$users = array_map('utf8_encode', $users);
    foreach($users_fetch as $r){
        //$r = array_map('utf8_encode', $r);
        array_push($users, $r["Opis"]);
        array_push($users_search, $r["Extra"]);
    }
    //echo var_dump($users);
    echo "<script>
    users = ".json_encode($users, JSON_UNESCAPED_UNICODE).";
    users_search = ".json_encode($users_search, JSON_UNESCAPED_UNICODE).";
    </script>";
    //echo (json_encode($users));
} catch(Exception $ex){
    //echo $ex->getMessage();
}
?>