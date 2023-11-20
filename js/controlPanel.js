const newEventBtn = document.getElementById("addEvent");
const addPopup = document.getElementById("addPopup");



newEventBtn.addEventListener('click', () => {
    addPopup.classList.add("open-popup");
})

const closePopup = document.getElementById("closePopup");
closePopup.addEventListener("click", function () {
    addPopup.classList.remove("open-popup");
})
