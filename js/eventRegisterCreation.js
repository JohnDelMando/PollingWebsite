var form = document.getElementById("my-creation-form");
form.addEventListener("submit", validateCreation);

var questionBox = document.getElementById("poll-askID");
questionBox.addEventListener("input", questCharCount);

var choice1Box = document.getElementById("choice-1ID");
choice1Box.addEventListener("input", choice1CharCount);

var choice2Box = document.getElementById("choice-2ID");
choice2Box.addEventListener("input", choice2CharCount);

var choice3Box = document.getElementById("choice-3ID");
choice3Box.addEventListener("input", choice3CharCount);

var choice4Box = document.getElementById("choice-4ID");
choice4Box.addEventListener("input", choice4CharCount);

var choice5Box = document.getElementById("choice-5ID");
choice5Box.addEventListener("input", choice5CharCount);