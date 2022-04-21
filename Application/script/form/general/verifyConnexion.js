//test

// variable
let formConnexion = document.getElementById('formConnexion');

//ok - mail
let mailRegex = /^([0-9a-zA-Z].*?@([0-9a-zA-Z].*\.\w{2,4}))$/

// ok - mdp
let passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[$@%*+\-_!?])[a-zA-Z\d$@%*+\-_!?]{10,}$/;


function ShowPasswordInput(eye, password){
    imageSrc = eye.getAttribute('src');
    if(imageSrc === 'public/images/general/notvisible.png'){
      eye.setAttribute('src', 'public/images/general/visible.png');
      password.setAttribute('type', 'text');
    } else if(imageSrc === 'public/images/general/visible.png'){
      eye.setAttribute('src', 'public/images/general/notvisible.png');
      password.setAttribute('type', 'password');
    }
}


// function validation input
function validMail(input, errorText){
  if(input.value === ""){
    errorText.textContent = "";
    return false;
  } else if(mailRegex.test(input.value) == false){
    errorText.textContent = "Le format du mail n\'est pas valide. Ex : john.doe@mail.fr";
    return false;
  } else if (input.value.length <= 7 || input.value.length >= 80){
    errorText.textContent = "La taille du mail n\'est pas bonne.";
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
    errorText.textContent = "Le format du mot de passe n\'est pas valide. Voir les consignes.";
    return false;
  } else if (input.value.length <= 2 || input.value.length >= 80){
    errorText.textContent = "La taille du mot de passe  n\'est pas bonne.";
    return false;
  } else {
    errorText.textContent= '';
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
