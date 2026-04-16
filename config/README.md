On the config folder. This is where I resuse the connection to *movie_site_db*, header, and theaters.

**connection.php** what I use most frequently to connect my database of MySQL through php, plus connection testing.

**Header**: Contains the script files that are used to run this website, mainly for design such as Bootstrap and W3. The other script
contains the fullcalendarJS framework to render calender, create, and read scheduling from the movies.

**theater**: A JSON format of theater selection (in AMC or can be changed if our product managers ask for Dallas College Location Only) to act
as 'cache data' for theater location. Its involved with **screenings* table data to send to MySQL and *tickets-purchase* to filter by location when purchasing tickets

**style.css**: created by @jesus to give our website more personalized than barebones Bootstrap 4 style. Doesnt apply to *schedule-create* page

Other than that, its all I have to include these files. May be added in the future (until May 14th for our last semester and I wont touch on it anymore.....sorta)
