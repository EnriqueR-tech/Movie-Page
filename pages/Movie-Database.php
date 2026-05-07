<!DOCTYPE html>
<html lang="en">

<?php 
include "../config/header.php" ;?>

<body>
    <div>
        <h1>Team Popcorn Movie</h1>
        <h2>Authorized user: Edit Movie Data CRUD</h2>
    </div>

    <nav class="navbar navbar-expand-lg bg-dark navbar-dark justify-content-center"> 
        <ul class="nav nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link text-white" href="../index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="movie-cards.php">Movies</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="tickets-purchase.php">Get Tickets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="aboutus.php">About Us</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link text-white dropdown-toggle" href="#" id="navbarDropdown"
                   role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Authorized Access
                </a>
                <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item active bg-danger" href="Movie-Database2.php">Add Movie</a>
                    <a class="dropdown-item" href="schedule-create.php">Schedule Screening</a>
                </div>
            </li>
        </ul>
    </nav>

    <?php
    // Flash message after hide/restore redirect
    if (isset($_GET['msg'])) {
        $msgMap = [
            'hidden'   => ['warning', '&#128683; Movie is now hidden from customers and scheduling.'],
            'restored' => ['success', '&#9989; Movie is now visible to customers.'],
            'blocked'  => ['danger',  '&#9888; Cannot hide — this movie still has active or upcoming screenings.'],
        ];
        if (isset($msgMap[$_GET['msg']])) {
            [$type, $text] = $msgMap[$_GET['msg']];
            echo "<div class='alert alert-{$type} alert-dismissible fade show mx-4 mt-3' role='alert'>
                    {$text}
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                  </div>";
        }
    }
    ?>

    <div>
        <div class="container-xl mt-4 p-4 bg-white">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Runtime</th>
                        <th>Rating</th>
                        <th>Tickets Sold</th>
                        <th>Visibility</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "../config/connection.php";

                    // Admin sees ALL movies — visible and hidden — hidden ones go to the bottom
                    $sql = "SELECT m.*, COALESCE(SUM(t.tickets), 0) AS total_tickets_sold
                            FROM movies m
                            LEFT JOIN tickets t ON m.movie_id = t.movie_id
                            GROUP BY m.movie_id
                            ORDER BY m.is_hidden ASC, m.movie_id ASC";
                    $result = $connection->query($sql);

                    while ($row = $result->fetch_assoc()) {

                        $ticketCount = (int)$row["total_tickets_sold"];
                        $isHidden    = (int)$row["is_hidden"];

                        $ticketBadge = $ticketCount > 0 ? "badge-success" : "badge-secondary";

                        // Gray out the whole row when hidden so admin can see at a glance
                        $rowClass = $isHidden ? "table-secondary" : "";

                        // Sanitize everything before it touches HTML attributes
                        $id          = (int)$row["movie_id"];
                        $title       = htmlspecialchars($row["title"],       ENT_QUOTES);
                        $runtime     = htmlspecialchars($row["runtime"],     ENT_QUOTES);
                        $rating      = htmlspecialchars($row["rating"],      ENT_QUOTES);
                        $description = htmlspecialchars($row["description"], ENT_QUOTES);
                        $image       = htmlspecialchars($row["image"],       ENT_QUOTES);

                        // Visibility badge + toggle button swap based on current state
                        if ($isHidden) {
                            $visibilityBadge = "<span class='badge badge-danger p-2'>&#128683; Hidden</span>";
                            $toggleBtn = "
                                <a href='../handlers/movies-toggleVisibility.php?id={$id}&action=show'
                                   class='btn btn-success btn-sm mb-1'
                                   onclick='return confirm(\"Make this movie visible again?\")'>
                                   &#9654; Restore
                                </a>";
                        } else {
                            $visibilityBadge = "<span class='badge badge-success p-2'>&#9654; Visible</span>";
                            $toggleBtn = "
                                <a href='../handlers/movies-toggleVisibility.php?id={$id}&action=hide'
                                   class='btn btn-secondary btn-sm mb-1'
                                   onclick='return confirm(\"Hide this movie from customers and scheduling? All sales will be cancled and ticket holders remain valid after showtimes\")'>
                                   &#128683; Hide
                                </a>";
                        }

                        $hiddenNote = $isHidden
                            ? "<br><small class='text-muted font-italic'>Hidden from customers</small>"
                            : "";

                        echo "
                        <tr class='{$rowClass}'>
                            <td>{$id}</td>
                            <td class='font-weight-bold'>{$title}{$hiddenNote}</td>
                            <td>{$runtime}</td>
                            <td>{$rating}</td>
                            <td class='text-center'>
                                <span class='badge p-2 {$ticketBadge}'>{$ticketCount}</span>
                            </td>
                            <td>{$visibilityBadge}</td>
                            <td>
                                <a href='#'
                                   class='btn btn-dark btn-sm mb-1'
                                   data-toggle='modal'
                                   data-target='#movieModal'
                                   data-id='{$id}'
                                   data-title='{$title}'
                                   data-runtime='{$runtime}'
                                   data-rating='{$rating}'
                                   data-description='{$description}'
                                   data-image='{$image}'>Details</a>

                                <a href='../handlers/movies-edit.php?id={$id}'
                                   class='btn btn-sm mb-1'
                                   style='background-color:#2265e2; color:white;'>Edit</a>

                                {$toggleBtn}

                                <a href='../handlers/movies-uploadimage.php?id={$id}'
                                   class='btn btn-link btn-sm'>Upload Image</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Movie Form -->
    <div class="container jumbotron bg-dark text-white mt-4">
        <p>Enter the movie you want to add:</p>
        <form class="form-group" action="../handlers/movies-save.php" method="post">
            <label for="title">Title: </label>
            <input type="text" id="title" name="title" required>

            <label for="number">Rating</label>
            <input type="text" id="number" name="rating" min="0.0" step="0.1" max="10.0" required>

            <label for="runtime">Runtime: </label>
            <input type="time" id="runtime" name="runtime" step="1" required>

            <label for="desc">Description: </label>
            <input type="text" id="desc" name="description" required>

            <button class="btn btn-success" type="submit">Send</button>
        </form>
    </div>

    <div class="container-fluid bg-dark text-white text-center p-3 mt-3">
        <footer>
            <p>Copyright &copy; 2024 Team Popcorn Movie</p>
            <br>
            <p>Designed by Team Popcorn: Enrique, Jesus, Hans, Nyab</p>
        </footer>
    </div>

    <!-- MODAL — JS populates all fields on Details click. No $row[] here. -->
    <div class="modal fade" id="movieModal" tabindex="-1"
         aria-labelledby="movieModalCardLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content mx-auto">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="movieModalCardLabel"></h5>
                    <button type="button" class="close bg-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-dark text-white">
                    <section class="movie-hero">
                        <div class="hero-bg" id="movieHeroBg" style="background-image: none;">
                            <div class="hero-overlay"></div>
                            <div class="hero-content">
                                <div class="hero-poster">
                                    <img src="" id="moviePoster" alt="Movie poster">
                                </div>
                                <div class="hero-info">
                                    <h1 id="movieModalTitle"></h1>
                                    <div class="d-flex justify-content-start mb-3">
                                        <h4 class="mb-3 mr-4">
                                            <span class="badge badge-success p-2" id="movieRuntime"></span>
                                        </h4>
                                        <h4 class="mb-3">
                                            <span class="badge badge-info p-2" id="movieRating"></span>
                                        </h4>
                                    </div>
                                    <p class="desc" id="movieOverview"></p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/movie-databaseModal.js"></script>
</body>
</html>
