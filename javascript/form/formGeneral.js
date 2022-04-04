//test

let firstname = document.getElementById('firstname');
let errorFirstname = document.getElementById('errorFirstname');
let lastname = document.getElementById('lastname');
let errorLastname = document.getElementById('errorLastname');
let pictureProfil = document.getElementById('pictureProfil');
let errorPictureProfil = document.getElementById('errorPictureProfil');
let description = document.getElementById('description');
let errorDescription = document.getElementById('errorDescription');
let mail = document.getElementById('mail');
let password = document.getElementById('password');
let errorMail = document.getElementById('errorMail');
let errorPassword = document.getElementById('errorPassword');
let eye = document.getElementById('eye');

// variables
let formConnexion = document.getElementById('formConnexion');
let formSinscription = document.getElementById('formSinscription');
let formTinscription = document.getElementById('formTinscription');


// REGEX
// ok firstname, lastname
let nameRegex = /^[a-zA-Zéèàùâêîôûëçëïüÿ]{2,}([-\s][a-zéèàùâêîôûëçëïüÿ]+)?$/i;

// ok - pseudo
let pseudoRegex = /^(?=.+[a-z])[a-zA-Z0-9éèàùâêîôûëçëïüÿ]+$/i;

//ok - mail
let mailRegex = /^([0-9a-zA-Z].*?@([0-9a-zA-Z].*\.\w{2,4}))$/

// ok - mdp
let passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[$@%*+\-_!?])[a-zA-Z\d$@%*+\-_!?]{10,}$/;

// ok - description
let stringRegex = /^[a-z0-9éèàùâêîôûëçëïüÿ\s'\-\.\!\?\,\:\;]+$/i;


function ShowPasswordInput(eye, password){
    imageSrc = eye.getAttribute('src');
    if(imageSrc === 'images/general/notvisible.png'){
      eye.setAttribute('src', 'images/general/visible.png');
      password.setAttribute('type', 'text');
    } else if(imageSrc === 'images/general/visible.png'){
      eye.setAttribute('src', 'images/general/notvisible.png');
      password.setAttribute('type', 'password');
    }
}


// function validation input
function validMail(input, errorText){
  if(input.value === ""){
    errorText.textContent = "";
    return false;
  } else if(mailRegex.test(input.value) == false){
    errorText.textContent = "Le format du mail n\'est pas valide."
    return false;
  } else if (input.value.length <= 7 || input.value.length >= 80){
    errorText.textContent = "La taille du mail n\'est pas bonne."
    return false;
  } else {
    errorText.textContent='';
    return true;
  }
}

function validPassword(input, errorText){
  if(input.value === ""){
    errorText.textContent = "";
    return false;
  } else if(passwordRegex.test(input.value) == false){
    errorText.textContent = "Le format du mot de passe n\'est pas valide."
    return false;
  } else if (input.value.length <= 2 || input.value.length >= 80){
    errorText.textContent = "La taille du mot de passe  n\'est pas bonne."
    return false;
  } else {
    errorText.textContent= '';
    return true;
  }
}

function validPseudo(input, errorText){
  if(input.value === ""){
    errorText.textContent = "";
    return false;
  } else if(pseudoRegex.test(input.value) == false){
    errorText.textContent = "Le format du pseudo n\'est pas valide."
    return false;
  } else if (input.value.length <= 2 || input.value.length >= 50){
    errorText.textContent = "La taille du pseudo  n\'est pas bonne."
    return false;
  } else {
    errorText.textContent= '';
    return true;
  }
}

function validName(input, errorText){
  if(input.value === ""){
    errorText.textContent = "";
    return false;
  } else if(nameRegex.test(input.value) == false){
    errorText.textContent = "Format non valide."
    return false;
  } else if (input.value.length <= 2 || input.value.length >= 50){
    errorText.textContent = "La taille du nom  n\'est pas bonne."
    return false;
  } else {
    errorText.textContent= '';
    return true;
  }
}

function validImage(input, errorText){
  let imageExtensions = ['jpeg','jpg', 'png'];
  let inputExtension = input.value.split('.').pop().toLowerCase();
  if(input.value === ""){
    errorText.textContent = '';
    return false;
    } else if(input.files[0].size >= 1000000){
    errorText.textContent = "L'image est trop volumineuse."
    return false;
    } else if(imageExtensions.includes(inputExtension) === false) {
        errorText.textContent = "Le format d\'image n\'est pas valide.";
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
  } else if(stringRegex.test(input.value) == false){
    errorText.textContent = "Le format n\'est pas valide. Il y a des caractères non autorisés."
    return false;
  } else if (input.value.length <= 2 || input.value.length > 500){
    errorText.textContent = "La description doit avoir entre 50 et 500 caractères."
    return false;
  } else {
    errorText.textContent='';
    return true;
  }
}

// Validation formulaires
// Formulaire connexion
if(formConnexion !== null){
  let mail = document.getElementById('mail');
  let password = document.getElementById('password');
  let errorMail = document.getElementById('errorMail');
  let errorPassword = document.getElementById('errorPassword');
  let eye = document.getElementById('eye');

  eye.addEventListener('click', () =>{
      ShowPasswordInput(eye, password)
  });

    mail.addEventListener('focusout', () => {
      validMail(mail, errorMail);
    });

    password.addEventListener('focusout', () => {
      validPassword(password, errorPassword);
    });

    formConnexion.addEventListener('submit', function(e) {
      e.preventDefault();
      if(validMail(mail, errorMail) && validPassword(password, errorPassword)){
          formConnexion.submit();
      };
    });
  }


// Formulaire Inscription student 
if(formSinscription !== null){
    let pseudo = document.getElementById('pseudo');
    let mail = document.getElementById('mail');
    let password = document.getElementById('password');
    
    let errorPseudo = document.getElementById('errorPseudo');
    let errorMail = document.getElementById('errorMail');
    let errorPassword = document.getElementById('errorPassword');
    
    let eye = document.getElementById('eye');

    eye.addEventListener('click', () =>{
        ShowPasswordInput(eye, password)
    });

    pseudo.addEventListener('focusout', () => {
      validPseudo(pseudo, errorPseudo);
    });

    mail.addEventListener('focusout', () => {
      validMail(mail, errorMail);
    });

    password.addEventListener('focusout', () => {
      validPassword(password, errorPassword);
    });

    formSinscription.addEventListener('submit', function(e) {
      e.preventDefault();
      if(validPseudo(pseudo, errorPseudo) && validMail(mail, errorMail) && validPassword(password, errorPassword)){
        formSinscription.submit();
      };
    });
}

if(formTinscription !== null){
  let firstname = document.getElementById('firstname');
  let errorFirstname = document.getElementById('errorFirstname');
  let lastname = document.getElementById('lastname');
  let errorLastname = document.getElementById('errorLastname');
  let pictureProfile = document.getElementById('pictureProfile');
  let errorPictureProfile = document.getElementById('errorPictureProfile');
  let description = document.getElementById('description');
  let errorDescription = document.getElementById('errorDescription');
  let mail = document.getElementById('mail');
  let password = document.getElementById('password');
  let errorMail = document.getElementById('errorMail');
  let errorPassword = document.getElementById('errorPassword');

  let eye = document.getElementById('eye');

  eye.addEventListener('click', () =>{
      ShowPasswordInput(eye, password)
  });

  firstname.addEventListener('focusout', () => {
    validName(firstname, errorFirstname);
  });

  lastname.addEventListener('focusout', () => {
    validName(lastname, errorLastname);
  });

  pictureProfile.addEventListener('focusout', () => {
    validImage(pictureProfile, errorPictureProfile);
  });
  
  description.addEventListener('focusout', () => {
    validDescription(description, errorDescription);
  });

  mail.addEventListener('focusout', () => {
    validMail(mail, errorMail);
  });

  password.addEventListener('focusout', () => {
    validPassword(password, errorPassword);
  });

  formTinscription.addEventListener('submit', function(e) {
    e.preventDefault();
    if(validName(firstname, errorFirstname) && validName(lastname, errorLastname) && validImage(pictureProfile, errorPictureProfile) && validDescription(description, errorDescription) && validMail(mail, errorMail) && validPassword(password, errorPassword)){
      formTinscription.submit();
    };
  });
}
