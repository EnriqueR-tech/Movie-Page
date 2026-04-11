Sample data for Movie website.

Down these sql files contain the data to view and display on the web page.

The file names should relate it as:

movie_details.sql is the **database** that hold 3 (or more later on) tables.

movielist.sql contains the movie information of : Title, Rating, Description, Image poster, and Runtime

screening.sql contain the calendar date of movie title, starttime and endtime

tickets.sql contain the movie title, ticket quanitity, and start times.


screening and tickets contain foreign key data connected to movielist

Self-Note: I know I screwed myself over on MySQL conventions that **movie_details.sql** shouldve been called *moviedb* instead. And its painfully concrete chewing experince that I need to delete *movie_details.sql* db then create a new db. Then import the table over. Hardest part is REWRITE the code to connect the database to **PHP**. 

