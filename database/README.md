<<<<<<< HEAD
Sample data for Movie website.

Down these sql files contain the data to view and display on the web page.

The file names should relate it as:

movie_details.sql is the **database** that hold 3 (or more later on) tables.

movielist.sql contains the movie information of : Title, Rating, Description, Image poster, and Runtime

screening.sql contain the calendar date of movie title, starttime and endtime

tickets.sql contain the movie title, ticket quanitity, and start times.


screening and tickets contain foreign key data connected to movielist

Self-Note: I know I screwed myself over on MySQL conventions that **movie_details.sql** shouldve been called *moviedb* instead. And its painfully concrete chewing experince that I need to delete *movie_details.sql* db then create a new db. Then import the table over. Hardest part is REWRITE the code to connect the database to **PHP**. 

=======
The sample  data for Movie website. The sample name of this sql is **movie_site_db**, which contains 3 table data (as of 4/16/2026 in this writing) that includes the table data.

The table data names are described from below

**movies.sql**: holds the movie information such as Title, rating/scoring, description, start/end times, and image poster. These data can be added from movies-Database.php CRUD.

**screenings.sql**: Holds important information on scheduling a movie from *movies.sql* as forgin key in *movie_id*. Used to render and show current movie schedule on the theater

**tickets.sql**: to purchase tickets by location, user/name, and quantity.

In my previous branches or commit (if I know where to find it). The naming conventions has changed to be conise and readable, since I screw myself over and refactoring the code to get it working.


This is the sample data used to read, write, and fetch to run this movie website.
>>>>>>> 8c4f0fb3b36e61381f6fb47e34b14f1a49956407
