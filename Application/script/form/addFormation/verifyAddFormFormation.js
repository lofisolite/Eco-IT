
// REGEX
// titre formation
let titleRegex = /^[a-zéèàùâêîôûëçëïüÿ\s\'\-\.\!\?\,\:\;]+$/i;

// description Formation
let descriptionRegex = /^[a-z0-9éèàùâêîôûëçëïüÿ\s'\-\.\!\?\,\:\;]+$/i;


// fonctions de vérification
function validTitle(input, errorText){
    if(input.value === ""){
        errorText.textContent = "";
        return false;
    } else if(titleRegex.test(input.value) == false){
        errorText.textContent = "Le format du titre n\'est pas valide. Est autorisé : lettre ou ('-!?,:.;)";
        return false;
    } else if (input.value.length >= 70){
        errorText.textContent = "La taille du titre n\'est pas bonne.";
        return false;
    } else {
        errorText.textContent= '';
        return true;
    }
}

function validDescription(input, errorText){
    if(input.value === ""){
        errorText.textContent = "";
        return false;
    } else if(descriptionRegex.test(input.value) == false){
        errorText.textContent = "Le format n\'est pas valide. Est autorisé : lettre, chiffre ou ('-!?,:.;).";
        return false;
    } else if (input.value.length <= 10 || input.value.length > 500){
        errorText.textContent = "La description doit avoir entre 10 et 500 caractères.";
        return false;
    } else {
        errorText.textContent='';
        return true;
    }
}

function validImage(input, errorText){
    let imageExtensions = ['jpeg','jpg', 'png'];
    let inputExtension = input.value.split('.').pop().toLowerCase();

    if(input.value === ""){
        errorText.textContent = '';
        return false;
    } else if(input.files[0].size >= 2000000){
        errorText.textContent = "L'image est trop volumineuse.";
        return false;
    } else if(imageExtensions.includes(inputExtension) === false) {
        errorText.textContent = "Le fichier n\'est pas une image.";
        return false;
    } else {
        errorText.textContent= '';
        return true;
    }
}

// variables input et erreurs
let formationTitle = document.getElementById('formationTitle');
let errorFormationTitle = document.getElementById('errorFormationTitle');

let description = document.getElementById('formationDescription');
let errorDescription = document.getElementById('errorFormationDescription');

let picture = document.getElementById('formationPicture');
let errorPicture = document.getElementById('errorFormationPicture');

// premier input section title
let sectionFirstTitle = document.getElementById('sectionTitle1');
let errorfirstSectionTitle = document.getElementById('errorSectionTitle1');

// tous les inputs section title
let inputsSectionTitle = document.querySelectorAll('input.sectionTitleClass');

let formAdd = document.getElementById('formAddFormation');

// vérifications des inputs
formationTitle.addEventListener('focusout', () => {
  validTitle(formationTitle, errorFormationTitle);
});

description.addEventListener('focusout', () => {
  validDescription(description, errorDescription);
});

picture.addEventListener('focusout', () => {
  validImage(picture, errorPicture);
});

let tableSection = '';
sectionFirstTitle.addEventListener('input', () => {
    let validation;
    validation = validTitle(sectionFirstTitle, errorfirstSectionTitle);
    if(validation === false){
        tableSection = false;
    } else if (validation === true) {
        tableSection = true;
    }
})

// observation inputs titre section ajouté dynamiquement
let container = document.getElementById('containerSections');
let config = { childList: true };

function observeContainerSection(mutationsList){
    let inputsSectionTitle = document.querySelectorAll('input.sectionTitleClass');
    for(let i=0; i < inputsSectionTitle.length; i++){
        inputsSectionTitle[i].addEventListener('input', () => {
        let id = i+1;
        let error = document.getElementById('errorSectionTitle'+id);
        let validation;
        validation = validTitle(inputsSectionTitle[i], error);
            if(validation === false){
                tableSection = false;
            } else if(validation === true) {
                tableSection = true;
            }
        });
    } 
}

let observer = new MutationObserver(observeContainerSection);
observer.observe(container, config);

// soumission du formulaire
formAdd.addEventListener('submit', function(e){
    e.preventDefault();
    if(validTitle(formationTitle, errorFormationTitle) && validDescription(description, errorDescription) && validImage(picture, errorPicture) && tableSection === true){
      formAdd.submit();
    } 
});

