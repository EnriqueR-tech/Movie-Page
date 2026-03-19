//This is my 2nd attempt to provide input from HTML to Javascript
//Gather 5 inputs with button as click event
//Push the input on a list
//read each element on the list to the table cell


const formEL = document.querySelector("form")
const tbodyEL = document.querySelector("tbody")

function sendData(n,g, d, s, s1, s2){
 let data = {name:n,
    genre:g,
    desc:d,
    date: s,
    start: s1,
    end: s2
 }
 const id = Date.now()
 const sendDataString = JSON.stringify(data)
 localStorage.setItem(id, sendDataString)

}
function loadData(){
    const savedData = localStorage.getItem()
    if (savedData) {
        const data = JSON.parse(savedData);
        const tableBody = document.getElementById("insert");

        const row = `
            <tr>
                <td>${data.name}</td>
                <td>${data.genre}</td>
                <td>${data.desc}</td>
                <td>${data.date}</td>
                <td>${data.start}</td>
                <td>${data.end}</td>
            </tr>
        `;
        tableBody.innerHTML = row;
    }
}


function addTable(e){

    const nameD = document.getElementById("name").value
    const genreD = document.getElementById("genre").value
    const descD = document.getElementById("desc").value
    const showtimeD = document.getElementById("showtime").value
    const stime24 = document.getElementById("Stime").value
    const etime24 = document.getElementById("Etime").value

    const stime12 = convertTo12Hour(stime24)
    const etime12 = convertTo12Hour(etime24)

    sendData(nameD, genreD, descD, showtimeD, stime12, etime12)

    tbodyEL.innerHTML += `
    <tr>
        <td>${nameD}</td>
        <td>${genreD}</td>
        <td>${descD}</td>
        <td>${showtimeD}</td>
        <td>${stime12}</td>
        <td>${etime12}</td>
        
        <td><button class="deleteBtn">Delete</button></td>
    </tr>`
    formEL.reset(); 

    //alert(name + genre + desc + showtime) 
}

function delCell(e){
    if (e.target.classList.contains("deleteBtn")){
        e.target.closest("tr").remove();
    }
}

function convertTo12Hour(time24){
    if (!time24) return ""
    let [hours, minutes] = time24.split(":")

    hours = parseInt(hours)
    minutes = minutes.padStart(2, "0")

    let period = "AM";
    
    if (hours >= 12){
        period = "PM"
    }
    hours = hours % 12;

    if (hours == 0){
        hours = 12;
    }
    return `${hours}:${minutes} ${period}`
}
//window.onload = loadData;
tbodyEL.addEventListener("click", delCell)
formEL.addEventListener("submit", addTable)