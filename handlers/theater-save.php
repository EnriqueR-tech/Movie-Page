<?php
session_start();

if (isset($_GET['theater'])) {
    $_SESSION['theater'] = $_GET['theater'];
}

header("Location: ../pages/tickets-purchase.php");
exit;
?>