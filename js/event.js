const controlPanelBtn = document.getElementById("btnControlPanel");
const viewSpeakersBtn = document.getElementById("btnSpeakers");

controlPanelBtn.addEventListener('click', () => {
    window.location.href = 'controlPanel.html';
})

viewSpeakersBtn.addEventListener('click', () => {
    window.location.href = 'eventSpeakers.html';
})