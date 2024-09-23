// sidebar toggle
let toggleBtn = document.querySelector("#toggle-btn");

toggleBtn.addEventListener("click", function() {
    let sidebar = document.querySelector(".sidebar");
    sidebar.classList.toggle('collapse');
});