
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
        errorText.textContent = "Le format du titre n\'est pas valide. Il y a des caractères non autorisés";
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
        errorText.textContent = "Le format de vidéo youtube n\'est pas valide.";
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
        errorText.textContent = "Le format n\'est pas valide. Il y a des caractères non autorisés.";
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
let errorLessonTitles = document.getElementsByClassName('errorLessonTitle');

// contenu de la video
let lessonVideos = document.getElementsByClassName('lessonVideoClass');
let errorLessonVideos = document.getElementsByClassName('errorLessonVideo');

// contenu de leçon
let lessonContents = document.getElementsByClassName('lessonContentClass');
let errorLessonContents = document.getElementsByClassName('errorLessonContent');

// container à ressources
let containerRessources = document.getElementsByClassName('containerResources');


// formulaire
let form = document.getElementById('formAddFormationStep');


// Vérification des titres des leçons
let validation;
let lessonTitleValidation;
for(let i=0; i < lessonTitles.length; i++){
    lessonTitles[i].addEventListener('focusout', () => {
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
for(let i=0; i < lessonVideos.length; i++){
    lessonVideos[i].addEventListener('focusout', () => {
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
for(let i=0; i < lessonContents.length; i++){
    lessonContents[i].addEventListener('focusout', () => {
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

// vérification ressources
// je dois observer l'ensemble des container à resource, lorsqu'il détecte un ajout d'input, je leur ajoute un event
let config = { childList: true, subtree:true };

// pour tout les container (un par leçon)
for(let i=0; i < containerRessources.length; i++){
    let id = i+1;
    // observe chaque container et exécute cette fonction
    let observer = new MutationObserver(observeContainerRessources);
    observer.observe(document.getElementById('lesson'+id+'containerResources'), config);
}

let ressourceTitleValidationtable = [];
let ressourceURLValidationtable = [];
function observeContainerRessources(mutationsList){
    let containerResource = mutationsList[0].target;
    let inputsResourceTitleError = containerResource.getElementsByClassName('resourceTitleError');
    let inputsResourceTitle = containerResource.getElementsByClassName('ressourceTitleInputs');
    
    for(let i=0; i < inputsResourceTitle.length; i++){
        inputsResourceTitle[i].addEventListener('input', () =>{
            let error = inputsResourceTitleError[i];
            validation = validTitle(inputsResourceTitle[i], error);
            if(validation === false){
                ressourceTitleValidationtable[i] = false;
            } else if(validation === true) {
                ressourceTitleValidationtable[i] = true;
            }
        });
        
    }

    let inputsResourceURLError = containerResource.getElementsByClassName('resourceURLError');
    let inputsResourceURL = containerResource.getElementsByClassName('ressourceURLInputs');
    
    for(let i=0; i < inputsResourceURL.length; i++){
        inputsResourceURL[i].addEventListener('input', () => {
            let error = inputsResourceURLError[i];
            validation = validURL(inputsResourceURL[i], error);
            if(validation === false){
                ressourceURLValidationtable[i] = false;
            } else if(validation === true) {
                ressourceURLValidationtable[i] = true;
            }
        });
        
    }
}

function notFalse(table){
    if(table.includes(false)){
        return false;
    } else {
        return true;
    }
}

let essai = notFalse(ressourceTitleValidationtable);
let essai2 = notFalse(ressourceURLValidationtable);

// soumission du formulaire
form.addEventListener('submit', function(e){
    console.log('nope...');
    e.preventDefault();
    if(
        lessonTitleValidation === true 
        && lessonVideoValidation === true 
        && lessonContentValidation === true 
        && essai === true 
        && essai2 === true){
        console.log('yep');
            form.submit(); 
    } 
});

