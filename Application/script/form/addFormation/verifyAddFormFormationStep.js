
// REGEX
// titre formation
let titleRegex = /^[a-zéèàùâêîôûëçëïüÿ\s\'\-\.\!\?\,\:\;]+$/i;

// video youtube
let youtubeRegex = /^(https?\:\/\/)?(www\.youtube\.com|youtu\.be)\/.+$/;

// contenu leçon
let contentRegex = /^[a-z0-9éèàùâêîôûëçëïüÿ\s\'\-\.\!\?\,\:\;]+$/i;


// fonctions de vérification
function validTitle(input, errorText){
    if(input.value === ""){
        errorText.textContent = "";
        return false;
    } else if(titleRegex.test(input.value) == false){
        errorText.textContent = "Le format du titre n\'est pas valide. Est autorisé : lettre ou ('-!?,.:;)";
        return false;
    } else if (input.value.length >= 70){
        errorText.textContent = "La taille du titre n\'est pas bonne.";
        return false;
    } else {
        errorText.textContent= '';
        return true;
    }
}

function validVideo(input, errorText){
    if(input.value === ""){
        errorText.textContent = "";
        return false;
    } else if(youtubeRegex.test(input.value) == false){
        errorText.textContent = "Ce n'est pas une vidéo youtube valide. ex : https://www.youtube.com/watch?v=ZHd-6n5juac&ab_channel=FredericBisson";
        return false;
    } else {
        errorText.textContent='';
        return true;
    }
}

function validContent(input, errorText){
    if(input.value === ""){
        errorText.textContent = "";
        return false;
    } else if(contentRegex.test(input.value) == false){
        errorText.textContent = "Le format n\'est pas valide. Est autorisé : lettre, chiffre ou ('-!?,.:;).";
        return false;
    } else if (input.value.length <= 50 || input.value.length > 20000){
        errorText.textContent = "La leçon doit avoir entre 50 et 20 000 caractères.";
        return false;
    } else {
        errorText.textContent='';
        return true;
    }
}


function validURL(input, errorText){
    let filesExtensions = ['jpeg','jpg', 'png', 'pdf'];
    let inputExtension = input.value.split('.').pop().toLowerCase();

    if(input.value === ""){
        errorText.textContent = '';
        return false;
    } else if(input.files[0].size >= 1000000){
        errorText.textContent = "L'image est trop volumineuse.";
        return false;
    } else if(filesExtensions.includes(inputExtension) === false) {
        errorText.textContent = "Le fichier n\'est pas une image ou un pdf.";
        return false;
    } else {
        errorText.textContent= '';
        return true;
    }
}

// variables input et erreurs
// titres de leçon
let lessonTitles = document.getElementsByClassName('lessonTitleClass');

// contenu de la video
let lessonVideos = document.getElementsByClassName('lessonVideoClass');

// contenu de leçon
let lessonContents = document.getElementsByClassName('lessonContentClass');

let allLesson = document.getElementById('allLesson');

// formulaire
let form = document.getElementById('formAddFormationStep');


// Vérification des titres des leçons

let validation;
let lessonTitleValidation;
if(allLesson !== null){
    lessonTitleValidation = true;
}
for(let i=0; i < lessonTitles.length; i++){
    lessonTitles[i].addEventListener('input', () => {
    let id = i+1;
    let error = document.getElementById('errorLessonTitle'+id);
    validation = validTitle(lessonTitles[i], error);
        if(validation === false){
            lessonTitleValidation = false;
        } else if(validation === true) {
            lessonTitleValidation = true;
        }
    });
}


// Vérification des videos des leçons
let lessonVideoValidation;
if(allLesson !== null){
    lessonVideoValidation = true;
}
for(let i=0; i < lessonVideos.length; i++){
    lessonVideos[i].addEventListener('input', () => {
    let id = i+1;
    let error = document.getElementById('errorLessonVideo'+id);
    validation = validVideo(lessonVideos[i], error);
        if(validation === false){
            lessonVideoValidation = false;
        } else if(validation === true) {
            lessonVideoValidation = true;
        }
    });
}

// Vérification des contenu des leçons
let lessonContentValidation;
if(allLesson !== null){
    lessonContentValidation = true;
}
for(let i=0; i < lessonContents.length; i++){
    lessonContents[i].addEventListener('input', () => {
    let id = i+1;
    let error = document.getElementById('errorLessonContent'+id);
    validation = validContent(lessonContents[i], error);
        if(validation === false){
            lessonContentValidation = false;
        } else if(validation === true) {
            lessonContentValidation = true;
        }
    });
}

// soumission du formulaire
form.addEventListener('submit', function(e){
    e.preventDefault();
    if(lessonTitleValidation === true && lessonVideoValidation === true && lessonContentValidation === true){
        form.submit(); 
    } 
});

