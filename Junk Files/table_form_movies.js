//Self note: This is a messy program I borrowed to understand javascript
//Unused file

var movieArray = [
        {'name': 'MovieA', 'Genre': 'Action','Description':"Man kills dog and out for revenge", 'Showtimes': 'Monday 5pm- 7pm'},
        {'name': 'MovieB', 'Genre': 'Thriller','Description':"Robots and transformations" ,'Showtimes': 'Monday 3pm - 6pm'},
        {'name': 'MovieC', 'Genre': 'Horror','Description':"Dumb teenagers awaken a secret monster" ,'Showtimes': 'Monday 5pm-7pm'},
    ]

    function buildTable(data){ //Get data from a list/dictionary
        var table = document.getElementById("movie")

        for( var i = 0; i < data.length; i++){
            var row = `<tr> 
                <td>${data[i].name}</td>
                <td>${data[i].Genre}</td>
                <td>${data[i].Description}</td>
                <td>${data[i].Showtimes}</td>
                 </tr>`

            table.innerHTML += row //Return the resulted cell to HTML from variable

        }
    }
    function addItems(){
        
        var name = document.getElementById("name").value
        var genre = document.getElementById("genre").value
        var des = document.getElementById("desc").value
        var show = document.getElementById("showtime").value

        let newMovie = {
            name: name,
            Genre: genre,
            Description: des,
            Showtimes: show
    }
    // add to array
    movieArray.push(newMovie)

    // clear existing table
    document.getElementById("movie").innerHTML = ""

    // rebuild table
    buildTable(movieArray)
    }
    
    buildTable(movieArray)
    const btn = document.getElementById("submit")
    btn.addEventListener("click", addItems)
    
        
    

      

    