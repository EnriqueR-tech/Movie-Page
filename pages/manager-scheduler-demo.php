<?php
/**
 * BACKLOG ITEM: Manager Movie Scheduling Logic
 * 
 * TASK 5: Find a way to validate or redesign "Start Time" and "End Time" on screening page.
 * (Achieved below by using HTML5 'time' inputs and PHP validation).
 */

$startTime = "";
$endTime = "";
$selectedMovieRuntime = "";
$calcLog = "";

// TASK 2: When a start time is entered, end time is automatically calculated
// (In PHP, this triggers when the manager submits the form to the server).
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $startTime = $_POST['movieStart'];
    $selectedMovieRuntime = $_POST['movieSelect'];

    if (!empty($startTime) && !empty($selectedMovieRuntime)) {
        
        /**
         * TASK 4: Find a way to round up to the nearest zero.
         * (e.g. runtime is 1:45:00 but rounded to 2:00:00)
         */
        $parts = explode(':', $selectedMovieRuntime);
        $hours = (int)$parts[0];
        $minutes = (int)$parts[1];

        // Logic: If there are any minutes, increment the hour and set minutes to 0.
        $roundedHours = ($minutes > 0) ? $hours + 1 : $hours;

        /**
         * TASK 1: End time equals start time plus movie runtime.
         * (Using the rounded buffer calculated above).
         */
        $startDt = new DateTime($startTime);
        $startDt->add(new DateInterval("PT{$roundedHours}H"));
        
        // Format for the time input (HH:MM)
        $endTime = $startDt->format('H:i');

        // Logging the logic for the presentation monitor
        $calcLog = "Parsed: $selectedMovieRuntime | Buffer Applied: {$roundedHours}hrs | Math: $startTime + {$roundedHours}hrs = $endTime";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sprint 4: PHP Manager Scheduler</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        .task-list { list-style: none; padding-left: 0; }
        .completed { text-decoration: line-through; color: #28a745; font-weight: bold; }
        .logic-monitor { background: #f1f3f5; border-left: 4px solid #28a745; padding: 15px; }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-4">Manager Scheduling System (PHP)</h2>

    <div class="row">
        <!-- FORM COLUMN -->
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">Create Screening</div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label>Movie (Runtime from Database)</label>
                            <select class="custom-select" name="movieSelect">
                                <option value="01:45:00" <?php if($selectedMovieRuntime == "01:45:00") echo "selected"; ?>>Movie A (01:45:00)</option>
                                <option value="02:10:00" <?php if($selectedMovieRuntime == "02:10:00") echo "selected"; ?>>Movie B (02:10:00)</option>
                                <option value="01:00:00" <?php if($selectedMovieRuntime == "01:00:00") echo "selected"; ?>>Movie C (01:00:00)</option>
                            </select>
                        </div>

                        <!-- TASK 5 Redesign: Validated Time Input -->
                        <div class="form-group">
                            <label>Start Time</label>
                            <input type="time" class="form-control" name="movieStart" value="<?php echo $startTime; ?>" required>
                        </div>

                        <!-- TASK 3: User can override if needed -->
                        <!-- Value is populated by PHP calculation, but input is editable by manager -->
                        <div class="form-group">
                            <label>End Time (Auto-Calculated)</label>
                            <input type="time" class="form-control" name="movieEnd" value="<?php echo $endTime; ?>">
                            <small class="text-success">End time defaults to Start + Runtime (Rounded).</small>
                        </div>

                        <button type="submit" class="btn btn-success btn-block">Process Schedule</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- PRESENTATION / LOGIC TRACKER COLUMN -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">Backlog Task Status</div>
                <div class="card-body">
                    <ul class="task-list">
                        <li class="<?php echo $endTime ? 'completed' : ''; ?>">✔ Task 1: End time = Start + Runtime</li>
                        <li class="<?php echo $endTime ? 'completed' : ''; ?>">✔ Task 2: Auto-calculate on entry (Submit)</li>
                        <li class="">☐ Task 3: User can override (Editable Field)</li>
                        <li class="<?php echo $endTime ? 'completed' : ''; ?>">✔ Task 4: Round up to nearest zero</li>
                        <li class="<?php echo $endTime ? 'completed' : ''; ?>">✔ Task 5: Validated Time Input Redesign</li>
                    </ul>

                    <?php if($calcLog): ?>
                        <div class="logic-monitor mt-4">
                            <h6>PHP Logic Monitor:</h6>
                            <code><?php echo $calcLog; ?></code>
                        </div>
                    <?php else: ?>
                        <p class="text-muted italic">Submit the form to see PHP logic execution.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
