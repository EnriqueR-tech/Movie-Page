<!DOCTYPE html>
<html lang="en">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Popcorn Movie - Schedule</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="title">
        <h1 id="title-text">Team Popcorn Movie</h1>
    </div>

    <div class="links">
        <a href="index.html">Home</a>
        <a href="#">Get Tickets</a>
        <a href="#">About Us</a>
        <a href="#">Menu/Food/Drinks</a>
    </div>

    <div class="page">

        <div class="side-bar">
            </div>

        <div class="content">
            
            <div class="filter-section">
                <form action="index.php" method="GET">
                    <label for="show-date">View Schedule For:</label>
                    <input type="date" id="show-date" name="date" value="2026-03-25">
                    <button type="submit">Filter</button>
                </form>
            </div>

            <div class="movie-row">
                <div class="movie-image">
                    <div class="genre">Sci-Fi / Action</div>
                    <img src="placeholder-movie.jpg" alt="Movie Poster" style="width:100px;">
                </div>

                <div class="movie-info">
                    <h3>Interstellar Journey</h3>
                    <p>A team of explorers travel through a wormhole in space in an attempt to ensure humanity's survival.</p>
                </div>

                <div class="movie-actions">
                    <div class="showtimes">
                        <strong>Today's Times:</strong>
                        <span>1:00 PM</span>, <span>4:30 PM</span>, <span>8:00 PM</span>
                    </div>
                    <button class="buy-btn">Purchase tickets</button>
                </div>
            </div>

            <hr>

            <div class="movie-row">
                <div class="movie-image">
                    <div class="genre">Comedy</div>
                    <img src="placeholder-movie.jpg" alt="Movie Poster" style="width:100px;">
                </div>

                <div class="movie-info">
                    <h3>The Office Outing</h3>
                    <p>When a corporate retreat goes wrong, one accountant must save the day using only a stapler.</p>
                </div>

                <div class="movie-actions">
                    <div class="showtimes">
                        <strong>Today's Times:</strong>
                        <span>2:15 PM</span>, <span>5:00 PM</span>, <span>9:30 PM</span>
                    </div>
                    <button class="buy-btn">Purchase tickets</button>
                </div>
            </div>

        </div>

        <div class="side-bar"></div>

    </div>

</body>
</html>
