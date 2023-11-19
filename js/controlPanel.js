const newEventBtn = document.getElementById("addEvent");
const addBtn = document.getElementById("addBtn");
const addPopup = document.getElementById("addPopup");
const closePopup = document.getElementById("closePopup");

const logOutBtn = document.getElementById("logOut");

const addSpeakerBtn = document.getElementById("addSpeaker");
const speakerDropdown = document.querySelector(".import-speaker");

const addPartnerBtn = document.getElementById("addPartner");
const partnerDropdown = document.querySelector(".import-partner");

const addContactBtn = document.getElementById("addContact");
const contactDropdown = document.querySelector(".import-contact");

const addDayBtn = document.getElementById("addDay");
const inputDay = document.querySelector(".import-day");


let dayCounter = 1;


newEventBtn.addEventListener('click', () => {
    addPopup.classList.add("open-popup");
})

logOutBtn.addEventListener('click', () => {
    window.location.href = 'login.html';
})

addBtn.addEventListener('click', () => {
    const addedElements = document.querySelectorAll(".flex");
    addedElements.forEach(element => element.remove());

    const addedDays = document.querySelectorAll(".days-header");
    addedDays.forEach(element => element.remove());

    // const form = document.querySelector("form");
    // form.reset();
    //
    // addPopup.classList.remove("open-popup");
})

closePopup.addEventListener('click', () => {
    addPopup.classList.remove("open-popup");
})

function removeInput() {
    this.parentElement.remove();
}

function removeDay() {
    this.parentElement.remove();
    dayCounter--;
}

// addSpeakerBtn.addEventListener("click", () => {
//     const speaker = document.createElement("select");
//
//     const btn = document.createElement("button");
//     btn.className = "delete";
//     btn.innerHTML = "&times";
//
//     btn.addEventListener("click", removeInput);
//
//     const flex = document.createElement("div");
//     flex.className = "flex";
//
//     speakerDropdown.appendChild(flex)
//     flex.appendChild(speaker);
//     flex.appendChild(btn);
// });

// addPartnerBtn.addEventListener("click", () => {
//     const partner = document.createElement("select");
//
//     const btn = document.createElement("button");
//     btn.className = "delete";
//     btn.innerHTML = "&times";
//
//     btn.addEventListener("click", removeInput);
//
//     const flex = document.createElement("div");
//     flex.className = "flex";
//
//     partnerDropdown.appendChild(flex)
//     flex.appendChild(partner);
//     flex.appendChild(btn);
// });

// addContactBtn.addEventListener("click", () => {
//     const contact = document.createElement("select");
//
//     const btn = document.createElement("button");
//     btn.className = "delete";
//     btn.innerHTML = "&times";
//
//     btn.addEventListener("click", removeInput);
//
//     const flex = document.createElement("div");
//     flex.className = "flex";
//
//     contactDropdown.appendChild(flex)
//     flex.appendChild(contact);
//     flex.appendChild(btn);
// });

// addDayBtn.addEventListener("click", () => {
//     const dayHeader = document.createElement("div");
//     dayHeader.className = "days-header";
//
//     const header = document.createElement("h4");
//     header.innerHTML = "Day " + dayCounter;
//
//     const addBtn = document.createElement("button");
//     addBtn.className = "addActivity";
//     addBtn.innerHTML = "+";
//
//     const removeBtn = document.createElement("button");
//     removeBtn.className = "removeDay";
//     removeBtn.innerHTML = "-";
//
//     removeBtn.addEventListener("click", removeDay);
//
//     const inputActivity = document.createElement("div");
//     inputActivity.className = "import-activity";
//
//     inputDay.appendChild(dayHeader)
//     dayHeader.appendChild(header)
//     dayHeader.appendChild(addBtn)
//     dayHeader.appendChild(removeBtn)
//     dayHeader.appendChild(inputActivity)
//
//     addBtn.addEventListener("click", (e) => {
//         e.preventDefault();
//         const name = document.createElement("input");
//         name.type = "text";
//         name.placeholder = "Activity";
//
//         const time = document.createElement("input");
//         time.type = "time";
//
//         const btn = document.createElement("button");
//         btn.className = "delete";
//         btn.innerHTML = "&times";
//
//         btn.addEventListener("click", removeInput);
//
//         const flex = document.createElement("div");
//         flex.className = "flex";
//
//         inputActivity.appendChild(flex)
//         flex.appendChild(name);
//         flex.appendChild(time);
//         flex.appendChild(btn);
//     })
//
//     dayCounter++;
// })