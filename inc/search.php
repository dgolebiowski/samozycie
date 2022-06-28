<?php 
    include_once("elasticsearch.php");
?>


    <div class="title">Wyszukaj</div>
    <div class="przelew">
        <div class="form-group">
            <form action="admin_search.php" method="POST">
                <div class="form-group">
                    <label for="userSearch">Login</label>
                    <input type="text" id="userSearch" name="userSearch" class="form-control" autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="submit" value="Szukaj" class="btn btn-form">
                </div>
            </form>
        </div>
        </form>
    </div>
