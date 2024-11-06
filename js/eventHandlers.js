// HANDLERS or VALIDATORS

function validateEmail(email) {
    let emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;

    if (emailRegex.test(email))
        return true;
    else
        return false;
}

function validatePassword(pwd) {
    let pwdRegex = /^[^\s]{8,}$/;
    
    if (pwdRegex.test(pwd))
        return true;
    else
        return false;
}

function validateUsername(uname) {
    let unameRegex = /^\w+$/;

    if (unameRegex.test(uname))
        return true;
    else
        return false;
}

function validateAvatar(avatar) {
    let avatarRegex = /^[^\n]+.[a-zA-Z]{3,4}$/;

    if (avatarRegex.test(avatar))
        return true;
    else
        return false;
}

function validateQuestion(question) {
    let questionRegex = /^(?!\s*$).{1,100}$/;

    if (questionRegex.test(question))
        return true;
    else
        return false;
}

function validateChoice(choice) {
    let choiceRegex = /^(?!\s*$).{0,50}$/;

    if (choiceRegex.test(choice))
        return true;
    else
        return false;
}

function validateDate(date) {
    let dateRegex = /^\d{4}-\d{2}-\d{2}$/;

    if (dateRegex.test(date))
        return true;
    else
        return false;
}

// LOG IN

function validateLogin(event) {
    let email = document.getElementById("e-mailID");
    let pwd = document.getElementById("pass-wordID");
    let email_err = document.getElementById("email-err");
    let pwd_err = document.getElementById("pass-word-err");
    let isFormValid = true;

    if (!validateEmail(email.value)) {
        email.classList.add("invalid");
        email_err.classList.remove("hidden");
        isFormValid = false;
    }
    else {
        email.classList.remove("invalid");
        email_err.classList.add("hidden");
    }

    if (!validatePassword(pwd.value)) {
        pwd.classList.add("invalid");
        pwd_err.classList.remove("hidden");
        isFormValid = false;
    }
    else {
        pwd.classList.remove("invalid");
        pwd_err.classList.add("hidden");

    }

    if (!isFormValid) {
        event.preventDefault();
    }
    else {
        console.log("Successful Login Validation");
    }
}

// SIGN UP
function validateSignup(event) {
    let email = document.getElementById("e-mailID");
    let uname = document.getElementById("user-nameID");
    let pwd = document.getElementById("pass-wordID");
    let cpwd = document.getElementById("cpass-wordID");
    let avatar = document.getElementById("avatarID");
    let email_err = document.getElementById("email-err");
    let uname_err = document.getElementById("user-name-err");
    let pwd_err = document.getElementById("pass-word-err");
    let cpwd_err = document.getElementById("cpass-word-err");
    let avatar_err = document.getElementById("avatar-err");
    let isFormValid = true;

    if (!validateEmail(email.value)) {
        email.classList.add("invalid");
        email_err.classList.remove("hidden");
        isFormValid = false;
    }
    else {
        email.classList.remove("invalid");
        email_err.classList.add("hidden");
    }

    if (!validateUsername(uname.value)) {
        uname.classList.add("invalid");
        uname_err.classList.remove("hidden");
        isFormValid = false;
    }
    else {
        uname.classList.remove("invalid");
        uname_err.classList.add("hidden");
    }

    if (!validatePassword(pwd.value)) {
        pwd.classList.add("invalid");
        pwd_err.classList.remove("hidden");
        isFormValid = false;
    }
    else {
        pwd.classList.remove("invalid");
        pwd_err.classList.add("hidden");

    }

    if(cpwd.value !== pwd.value) {
        cpwd.classList.add("invalid");
        cpwd_err.classList.remove("hidden");
        isFormValid = false;
    }
    else {
        cpwd.classList.remove("invalid");
        cpwd_err.classList.add("hidden");
    }

    if (!validateAvatar(avatar.value)) {
        avatar_err.classList.remove("hidden");
        isFormValid = false;
    }
    else {
        avatar_err.classList.add("hidden");
    }

    if (!isFormValid) {
        event.preventDefault();
    }
    else {
        console.log("Successful Signup Validation");
    }
}

// CREATION POLL

function validateCreation(event) {
    let question = document.getElementById("poll-askID");
    let question_err = document.getElementById("question-err");
    let openDate = document.getElementById("poll-open-timeID");
    let closeDate = document.getElementById("poll-close-timeID");
    let openDate_err = document.getElementById("opendate-err");
    let closeDate_err = document.getElementById("closedate-err");
    let choice1 = document.getElementById("choice-1ID");
    let choice2 = document.getElementById("choice-2ID");
    let choice3 = document.getElementById("choice-3ID");
    let choice4 = document.getElementById("choice-4ID");
    let choice5 = document.getElementById("choice-5ID");
    let choice1_err = document.getElementById("choice1-err");
    let choice2_err = document.getElementById("choice2-err");
    let choice3_err = document.getElementById("choice3-err");
    let choice4_err = document.getElementById("choice4-err");
    let choice5_err = document.getElementById("choice5-err");
    let isFormValid = true;
    let charLimit = "Exceeded character limit";

    if (!validateQuestion(question.value)) {
        if (question.value.length === 0) {
            question.classList.add("invalid");
            question_err.classList.remove("hidden");
            question_err.innerHTML = "Question box is empty";
        }
        else {
            question.classList.add("invalid");
            question_err.classList.remove("hidden");
            question_err.innerHTML = charLimit;
        }
        isFormValid = false;
    }
    else {
        question.classList.remove("invalid");
        question_err.classList.add("hidden");
    }
    
    if (!validateChoice(choice1.value)) {
        if(choice1.value.length === 0) {
            choice1.classList.add("invalid");
            choice1_err.classList.remove("hidden");
            choice1_err.innerHTML = "Choice must be filled in";
        }
        else {
            choice1.classList.add("invalid");
            choice1_err.classList.remove("hidden");
            choice1_err.innerHTML = charLimit;
        }
        isFormValid = false;
    }
    else {
        choice1.classList.remove("invalid");
        choice1_err.classList.add("hidden");
    }

    if (!validateChoice(choice2.value)) {
        if(choice2.value.length === 0) {
            choice2.classList.add("invalid");
            choice2_err.classList.remove("hidden");
            choice2_err.innerHTML = "Choice must be filled in";
        }
        else {
            choice2.classList.add("invalid");
            choice2_err.classList.remove("hidden");
            choice2_err.innerHTML = charLimit;
        }
        isFormValid = false;
    }
    else {
        choice2.classList.remove("invalid");
        choice2_err.classList.add("hidden");
    }

    if (!validateChoice(choice3.value)) {
        if(choice3.value.length === 0) {
            choice3.classList.add("invalid");
            choice3_err.classList.remove("hidden");
            choice3_err.innerHTML = "Choice must be filled in";
        }
        else {
            choice3.classList.add("invalid");
            choice3_err.classList.remove("hidden");
            choice3_err.innerHTML = charLimit;
        }
        isFormValid = false;
    }
    else {
        choice3.classList.remove("invalid");
        choice3_err.classList.add("hidden");
    }

    if (!validateChoice(choice4.value)) {
        if(choice4.value.length === 0) {
            choice4.classList.add("invalid");
            choice4_err.classList.remove("hidden");
            choice4_err.innerHTML = "Choice must be filled in";
        }
        else {
            choice4.classList.add("invalid");
            choice4_err.classList.remove("hidden");
            choice4_err.innerHTML = charLimit;
        }
        isFormValid = false;
    }
    else {
        choice4.classList.remove("invalid");
        choice4_err.classList.add("hidden");
    }

    if (!validateChoice(choice5.value)) {
        if(choice5.value.length === 0) {
            choice5.classList.add("invalid");
            choice5_err.classList.remove("hidden");
            choice5_err.innerHTML = "Choice must be filled in";
        }
        else {
            choice5.classList.add("invalid");
            choice5_err.classList.remove("hidden");
            choice5_err.innerHTML = charLimit;
        }
        isFormValid = false;
    }
    else {
        choice5.classList.remove("invalid");
        choice5_err.classList.add("hidden");
    }

    if (!validateDate(openDate.value)) {
        openDate.classList.add("invalid");
        openDate_err.classList.remove("hidden");
        isFormValid = false;
    }
    else {
        openDate.classList.remove("invalid");
        openDate_err.classList.add("hidden");
    }

    if (!validateDate(closeDate.value)) {
        closeDate.classList.add("invalid");
        closeDate_err.classList.remove("hidden");
        isFormValid = false;
    }
    else {
        closeDate.classList.remove("invalid");
        closeDate_err.classList.add("hidden");
    }

    if (!isFormValid) {
        event.preventDefault();
    }
    else {
        console.log("Successful Signup Validation");
    }
}

// dynamic char count

function questCharCount(event) {
    let questionBox = event.target; 
    let charCountElement = document.getElementById("quest-char");
  
    let maxLength = 100;
  
    let currentLength = questionBox.value.length; 
    let remainingChars = maxLength - currentLength; 
  
    charCountElement.textContent = `${remainingChars}\/100`;
}

function choice1CharCount(event) {
    let questionBox = event.target; 
    let charCountElement = document.getElementById("choice1-char");
  
    let maxLength = 50;
  
    let currentLength = questionBox.value.length; 
    let remainingChars = maxLength - currentLength; 
  
    charCountElement.textContent = `${remainingChars}\/50`;
}

function choice2CharCount(event) {
    let questionBox = event.target; 
    let charCountElement = document.getElementById("choice2-char");
  
    let maxLength = 50;
  
    let currentLength = questionBox.value.length; 
    let remainingChars = maxLength - currentLength; 
  
    charCountElement.textContent = `${remainingChars}\/50`;
}

function choice3CharCount(event) {
    let questionBox = event.target; 
    let charCountElement = document.getElementById("choice3-char");
  
    let maxLength = 50;
  
    let currentLength = questionBox.value.length; 
    let remainingChars = maxLength - currentLength; 
  
    charCountElement.textContent = `${remainingChars}\/50`;
}

function choice4CharCount(event) {
    let questionBox = event.target; 
    let charCountElement = document.getElementById("choice4-char");
  
    let maxLength = 50;
  
    let currentLength = questionBox.value.length; 
    let remainingChars = maxLength - currentLength; 
  
    charCountElement.textContent = `${remainingChars}\/50`;
}

function choice5CharCount(event) {
    let questionBox = event.target; 
    let charCountElement = document.getElementById("choice5-char");
  
    let maxLength = 50;
  
    let currentLength = questionBox.value.length; 
    let remainingChars = maxLength - currentLength; 
  
    charCountElement.textContent = `${remainingChars}\/50`;
}
  