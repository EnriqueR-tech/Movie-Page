//This is CHATGPT written and my goodness
//it doesnt work either the AI or my fucking mess that I write
//This will be my research purpose incase of future me reading this
//This file wont be used at all

const STORAGE_KEY = "movies";

const formEL = document.getElementById("movieForm");
const tbodyEL = document.getElementById("movieBody");

// ----- storage helpers -----
function loadMovies() {
  return JSON.parse(localStorage.getItem(STORAGE_KEY) || "[]");
}

function saveMovies(movies) {
  localStorage.setItem(STORAGE_KEY, JSON.stringify(movies));
}

// ----- optional: time formatting -----
function convertTo12Hour(time24) {
  if (!time24) return "";
  let [h, m] = time24.split(":");
  h = parseInt(h, 10);
  const period = h >= 12 ? "PM" : "AM";
  h = h % 12;
  if (h === 0) h = 12;
  return `${h}:${m.padStart(2, "0")} ${period}`;
}

// ----- render table from storage -----
function renderTable() {
  const movies = loadMovies();
  tbodyEL.innerHTML = "";

  movies.forEach((movie) => {
    const tr = document.createElement("tr");
    tr.dataset.id = movie.id;

    tr.innerHTML = `
      <td>${movie.title}</td>
      <td>${movie.genre}</td>
      <td>${movie.desc}</td>
      <td>${movie.showtime}</td>
      <td>${convertTo12Hour(movie.start)}</td>
      <td>${convertTo12Hour(movie.end)}</td>
      <td><button type="button" class="deleteBtn">Delete</button></td>
    `;

    tbodyEL.appendChild(tr);
  });
}

// 1) HTML input -> JS object -> JSON stored
function handleSubmit(e) {
  e.preventDefault();

  const movie = {
    id: crypto.randomUUID(), // unique key for delete/edit
    title: document.getElementById("name").value.trim(),
    genre: document.getElementById("genre").value.trim(),
    desc: document.getElementById("desc").value.trim(),
    showtime: document.getElementById("showtime").value,
    start: document.getElementById("Stime").value,
    end: document.getElementById("Etime").value
  };

  const movies = loadMovies();
  movies.push(movie);
  saveMovies(movies);

  renderTable();
  formEL.reset();
}

// 4) Delete row + delete JSON data
function handleDelete(e) {
  if (!e.target.classList.contains("deleteBtn")) return;

  const row = e.target.closest("tr");
  const id = row.dataset.id;

  const movies = loadMovies().filter(m => m.id !== id);
  saveMovies(movies);

  renderTable();
}

// 2 & 3) Persist + rebuild on refresh
formEL.addEventListener("submit", handleSubmit);
tbodyEL.addEventListener("click", handleDelete);
window.addEventListener("DOMContentLoaded", renderTable);