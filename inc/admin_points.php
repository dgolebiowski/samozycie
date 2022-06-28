
    <div class="title">Panel Admina - Dodawanie Punktów</div>
    <div class="przelew">
        <?php
            if(isset($_SESSION['success_add'])){
                echo $_SESSION['success_add'];
                unset($_SESSION['success_add']);
            }
            ?>

        <?php
                if($_SERVER['REQUEST_METHOD']=="POST"){
                    //echo var_dump($_POST);
                    if(!empty($_POST['loginAdd'])&&!empty($_POST['nazwa'])&&!empty($_POST['punkty'])){
                        try{
                            $points = $_POST['punkty'];
                            $loginAdd = $_POST['loginAdd'];
                            $note = $_POST['nazwa'];
                            $admin = $_SESSION['login'];
                            $stmt_add = $pdo->prepare("INSERT INTO zgloszenia VALUES(NULL, :loginAdd, NOW(), '-', 'Admin', :admin, :points, :note, '1', '1', '')");
                            $stmt_add->bindParam(":loginAdd", $loginAdd, PDO::PARAM_STR);
                            $stmt_add->bindParam(":admin", $admin, PDO::PARAM_STR);
                            $stmt_add->bindParam(":points", $points, PDO::PARAM_STR);
                            $stmt_add->bindParam(":note", $note, PDO::PARAM_STR);
                            $stmt_add->execute();
                            $stmt_user_add = $pdo->prepare("UPDATE user SET punkty = punkty + :points where login = :userAdd ");
                            $stmt_user_add->bindParam(":points", $points, PDO::PARAM_INT);
                            $stmt_user_add->bindParam(":userAdd", $loginAdd, PDO::PARAM_STR);
                            $stmt_user_add->execute();
                            $_SESSION['success_add'] = '<div class="alert alert-success">Pomyślnie dodano!</div>';
                            header("Location: /admin_punkty.php");
                        }
                        catch(Exception $ex){
                            echo var_dump($ex);
                        }
                        
                    }
                    else echo "Brak danych";
                }
            
            ?>
        <form method="post" action="admin_punkty.php">
            <div class="form-group">
                <label for="loginAdd">Tutaj wpisz login użytkownika, któremu chcesz dodać punkty:</label>
                <input type="text" class="form-control" id="loginAdd" name="loginAdd" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="note">Notatka Administracyjna:</label>
                <input type="text" class="form-control" id="note" name="nazwa">
            </div>

            <div class="form-group">
                <label for="points">Tutaj wpisz ile chcesz dodać punktów:</label>
                <input type="text" class="form-control" id="points" name="punkty">
            </div>
            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-form" value="Dodaj">
            </div>
        </form>
		
    </div>


    <div class="title">Panel Admina - Odejmowanie Punktów</div>
    <div class="przelew">

        <?php
                if(isset($_SESSION['success_sub'])){
                    echo $_SESSION['success_sub'];
                    unset($_SESSION['success_sub']);
                }
            ?>
        <?php
                if($_SERVER['REQUEST_METHOD']=="POST"){
                    //echo var_dump($_POST);
                    if(!empty($_POST['loginSub'])&&!empty($_POST['nazwa'])&&!empty($_POST['punkty'])){
                        try{
                            $points = $_POST['punkty'];
                            $loginSub = $_POST['loginSub'];
                            $note = $_POST['nazwa'];
                            $admin = $_SESSION['login'];
                            $stmt_sub = $pdo->prepare("INSERT INTO zgloszenia VALUES(NULL, 'Admin', NOW(), '-', :loginSub, :admin, :points, :note, '1', '2', '')");
                            $stmt_sub->bindParam(":loginSub", $loginSub, PDO::PARAM_STR);
                            $stmt_sub->bindParam(":admin", $admin, PDO::PARAM_STR);
                            $stmt_sub->bindParam(":points", $points, PDO::PARAM_STR);
                            $stmt_sub->bindParam(":note", $note, PDO::PARAM_STR);
                            $stmt_sub->execute();
                            $stmt_user_sub = $pdo->prepare("UPDATE user SET punkty = punkty - :points where login = :userSub ");
                            $stmt_user_sub->bindParam(":points", $points, PDO::PARAM_INT);
                            $stmt_user_sub->bindParam(":userSub", $loginSub, PDO::PARAM_STR);
                            $stmt_user_sub->execute();
                            $_SESSION['success_sub'] = '<div class="alert alert-success">Pomyślnie odjęto!</div>';
                            header("Location: /admin_punkty.php");
                        }
                        catch(Exception $ex){
                            echo var_dump($ex);
                        }
                        
                    }
                    else echo "Brak danych";
                }
                    
            ?>
        <form method="post" action="admin_punkty.php">
            <div class="form-group">
                <label for="loginSub">Tutaj wpisz login użytkownika, któremu chcesz zabrać punkty:</label>
                <input type="text" class="form-control" id="loginSub" name="loginSub" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="note">Notatka Administracyjna:</label>
                <input type="text" class="form-control" id="note" name="nazwa">
            </div>

            <div class="form-group">
                <label for="points">Tutaj wpisz ile chcesz odjąć punktów:</label>
                <input type="text" class="form-control" id="points" name="punkty">
            </div>
            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-form" value="Odejmij">
            </div>
        </form>

</div>