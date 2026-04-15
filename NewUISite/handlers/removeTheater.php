<?php
session_start();
unset($_SESSION['theater']);
unset($_SESSION['theater_key']);

header("Location: ../pages/theater-select.php");
exit;