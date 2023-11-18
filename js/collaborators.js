const newCollabBtn = document.getElementById("addCollab");
const addCollabBtn = document.getElementById("addBtn");

const backBtn = document.getElementById("backControlPanel");

const addPopup = document.getElementById("addPopup");
const closePopup = document.getElementById("closePopup");

newCollabBtn.addEventListener('click', () => {
    addPopup.classList.add("open-popup");
})

// addCollabBtn.addEventListener('click', () => {
//     const form = document.querySelector("form");
//     form.reset();
//
//     addPopup.classList.remove("open-popup");
// })

backBtn.addEventListener('click', () => {
    window.location.href = 'controlPanel.php';
})

closePopup.addEventListener('click', () => {
    addPopup.classList.remove("open-popup");
})
