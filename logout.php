<?php
session_start();
setcookie(session_name(), '', 100);
session_unset();
session_destroy();
$_SESSION = array();
?>
<html>
    <script>
        setTimeout(function() {
            window.location.href = "index.php";
        }, 3000);
    </script>
</head>
<body>
    <h1>Logging you out...</h1>
    <p>You will be redirected to the homescreen soon.</p>
</body>
</html>
