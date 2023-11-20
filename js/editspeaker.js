const editPopup = document.getElementById("editPopup");
const backBtn = document.getElementById("backControlPanel");


backBtn.addEventListener('click', () => {
    window.location.href = '/ProiectPHP/speakers.php';
})

editPopup.classList.add("open-popup");


