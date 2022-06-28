<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/jquery-1.8.2.min.js"></script>
<script src="js/jquery-tablesorter.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    function click() {
        if (event.button == 2 || event.button == 3) {
            oncontextmenu = 'return false';
        }
    }
    document.onmousedown = click
    document.oncontextmenu = new Function("return false;")
</script>
<script type="text/javascript">
    function getTime() {
        return (new Date()).toLocaleTimeString();
    }
    $('#czas').html(getTime());
    setInterval(function () {
        $('#czas').html(getTime());
    }, 1000);
</script>
<script type="text/javascript">
    $(function () {
        $('#loginAdd').autocomplete({
            source: users
        });
        $('#loginSub').autocomplete({
            source: users
        });
        $('#userSearch').autocomplete({
            source: users_search
        });
    });
    $(function () {
        $('.table').tablesorter();
    });

 $(document).ready(function () {
        setTimeout(function () {
            var cookies = document.cookie;
            if (!cookies.includes("cookie=ok"))
                $("#cookieConsent").fadeIn(200);
        }, 1000);
        $("#closeCookieConsent, .cookieConsentOK").click(function () {
            document.cookie = "cookie=ok";
            $("#cookieConsent").fadeOut(200);
        });
    });
</script>


<script>
function openNavMenu() {
  document.getElementById("Menu").style.width = "100%";
}

function closeNavMenu() {
  document.getElementById("Menu").style.width = "0";
}

function openNavUser() {
  document.getElementById("User").style.width = "100%";
}

function closeNavUser() {
  document.getElementById("User").style.width = "0";
}
</script>

<script type="text/javascript">
$(document).ready(function(){
        // iOS web app full screen hacks.
        if(window.navigator.standalone == true) {
                // make all link remain in web app mode.
                $('a').click(function() {
                        window.location = $(this).attr('href');
            return false;
                });
        }
});
</script>