const newSpeakerBtn = document.getElementById("addSpeaker");
const addSpeakerBtn = document.getElementById("addBtn");

const backBtn = document.getElementById("backControlPanel");

const addPopup = document.getElementById("addPopup");
const closePopup = document.getElementById("closePopup");

newSpeakerBtn.addEventListener('click', () => {
    addPopup.classList.add("open-popup");
})

addSpeakerBtn.addEventListener('click', () => {
    const form = document.querySelector("form");
    form.reset();

    addPopup.classList.remove("open-popup");
})

backBtn.addEventListener('click', () => {
    window.location.href = 'controlPanel.html';
})

closePopup.addEventListener('click', () => {
    addPopup.classList.remove("open-popup");
})
