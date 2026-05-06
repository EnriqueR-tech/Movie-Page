<?php

$startTime = "";
$endTime = "";
$runtime = "";
$calcLog = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $startTime = $_POST['movieStart'];
    $runtime = $_POST['movieSelect'];
    $manualEnd = $_POST['movieEnd'];

    if (!empty($startTime) && !empty($runtime)) {

        list($h, $m, $s) = explode(":", $runtime);
        $totalMinutes = ($h * 60) + $m;

        // Round up to nearest 30 min
        $roundedMinutes = ceil($totalMinutes / 30) * 30;

        $startDt = new DateTime($startTime);
        $startDt->add(new DateInterval("PT{$roundedMinutes}M"));

        $calculatedEnd = $startDt->format("H:i");

        // Allow override
        $endTime = !empty($manualEnd) ? $manualEnd : $calculatedEnd;

        $calcLog = "Start: $startTime | Runtime: {$h}h {$m}m | Rounded: {$roundedMinutes} mins | End: $endTime";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manager Scheduler</title>
</head>
<body style="background:#f5f5f5;font-family:sans-serif;">

<div style="max-width:800px;margin:50px auto;display:flex;gap:20px;">

    <!-- FORM -->
    <div style="flex:1;background:white;padding:20px;border-radius:10px;">
        <h3>Create Screening</h3>

        <form method="POST">
            <label>Movie</label>
            <select name="movieSelect" style="width:100%;padding:10px;">
                <option value="01:45:00">Movie A (1h45m)</option>
                <option value="02:10:00">Movie B (2h10m)</option>
                <option value="01:00:00">Movie C (1h)</option>
            </select>

            <label>Start Time</label>
            <input type="time" name="movieStart" value="<?php echo $startTime; ?>" required style="width:100%;padding:10px;">

            <label>End Time</label>
            <input type="time" name="movieEnd" value="<?php echo $endTime; ?>" style="width:100%;padding:10px;">

            <button type="submit" style="margin-top:10px;width:100%;padding:10px;background:green;color:white;">
                Process Schedule
            </button>
        </form>
    </div>

    <!-- LOG PANEL -->
    <div style="flex:1;background:white;padding:20px;border-radius:10px;">
        <h4>System Logic</h4>

        <?php if ($calcLog): ?>
            <pre><?php echo $calcLog; ?></pre>
        <?php else: ?>
            <p>No calculation yet.</p>
        <?php endif; ?>
    </div>

</div>
</body>
</html>
