This was once called *include* but that doesnt make sense to me. All it does to process data logic and checking before sending to MySQL. Now it is called **handler folder**

All the names in this files are related to the pages folder as I describe here: [Movie] [schedule] [theater] [tickets] The handler files relate the pages to see where data goes and process.

The naming convention for any files created (for my teams) should the be first word of pages seperated by `-` and its purpose: **[pagename] - [data handling process]**

Makes it easier to read what it does and its purpose. I can go over each handler pages

**movies**
A basic CRUD (Create, Read, Update, and Delete) or Save, Edit, and Delete seen here. Uploading images is included but all images saved MUST BE IN *assets>images* folder. Uploadimage can be accessed anywhere 
in your PC and makes a copy of it and save it in *assets>images* folder.

**screening**
This is where *fullcalendarJS* will be rendered, create, and stored at. Trouble is that Javascript cannot communicate to MySQL itself so it needs PHP to do the work. I used AJAX to communicate JS into PHP
for data process for logic testing. The screening save have non-overlapping schedule for **listview** function on fullcalendarJS. 
The Fetch file used to render the calendar back from MySQL data into the *index.php* and *schedule-create.php*

**theater**


*tickets**
