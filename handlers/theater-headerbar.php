<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . "/../config/theaters.php";

$currentKey = $_SESSION['theater_key'] ?? null;
$current = $currentKey && isset($theaters[$currentKey])
    ? $theaters[$currentKey]
    : null;
?>

<div class="amc-theater-bar">
    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 45 45" width="18" height="18">
        <path d="M34.65 4.808C31.277 1.436 26.499-.25 21.72.03 12.447.03 5.7 5.932 5.7 13.802c.843 11.524 5.902 22.204 14.053 30.074.562.562 1.405.843 2.249 1.124.843 0 1.405-.281 1.967-.843 5.902-5.06 14.615-18.831 14.334-30.355 0-3.373-1.405-6.745-3.653-8.994z"/>
    </svg>

    <a href="/MovieWebsite/pages/selectTheater.php" class="amc-theater-btn">
        <?php echo $current ?? "Select Theatre"; ?>
    </a>

    <?php if ($current): ?>
        <a href="/MovieWebsite/pages/removeTheater.php" class="amc-change">Change</a>
    <?php endif; ?>

    <a href="/MovieWebsite/pages/getTickets.php" class="amc-ticket-link">
        Get Tickets →
    </a>
</div>