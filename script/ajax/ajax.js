let url = document.location.origin + '/test/';

// Récupére les formations par mot clef et les dernières formations
function searchFormation(formElement){
    let request = new XMLHttpRequest();
    let data = new FormData(formElement);
    let divResultat = document.getElementById('resultat');
    
    request.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            console.log(this.responseText);
            divResultat.innerHTML = '';
            divResultat.innerHTML = this.responseText;
        } else if(this.readyState == 4){
            alert('une erreur est survenue, veuillez réessayer');
        } 
    }

    request.open('POST', url + 'controllers/ControllerAjax.php', true);

    request.send(data);
}

// Modifie le statut de la leçon
function updateLessonStatut(formElement){
    let request = new XMLHttpRequest();
    let data = new FormData(formElement);
    
    request.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            let status = this.response['status'];
            let btnInProgress = document.getElementById('btn-in-progress');
            let btnFinished = document.getElementById('btn-finished');
            let pStatus = document.getElementById('p-status-lesson');

            if(status === 'en cours'){
                pStatus.innerHTML = 'La leçon est en cours';
                btnInProgress.classList.add('btn-active');
                btnFinished.classList.remove('btn-active');
            } 
            
            if(status === 'terminé'){
                pStatus.innerHTML = 'Félicitation, vous avez terminé la leçon.';
                btnInProgress.classList.remove('btn-active');
                btnFinished.classList.add('btn-active');
            }
            
        } else if(this.readyState == 4){
            alert('une erreur est survenue, veuillez réessayer');
        } 
    }

    request.open('POST', url + 'controllers/ControllerAjax.php', true);
    request.responseType = 'json';
    request.send(data);
}

function updateFormationOnline(formElement){
    let request = new XMLHttpRequest();
    let data = new FormData(formElement);
    
    request.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            console.log(this.responseText);

        } else if(this.readyState == 4){
            alert('une erreur est survenue, veuillez réessayer');
        } 
    }

    request.open('POST', url + 'controllers/ControllerAjax.php', true);

    request.send(data);
}

// visiteur - recherche formation par mot clef
let formSearch = document.getElementById('form-search');

if(formSearch !== null){
    formSearch.addEventListener("submit", 
    function(e){
        e.preventDefault();

        searchFormation(formSearch);
    });
}

// student - recherche formation par mot clef
let formSearchStudent = document.getElementById('form-search-student');

if(formSearchStudent !== null){
    formSearchStudent.addEventListener("submit", 
    function(e){
        e.preventDefault();

        searchFormation(formSearchStudent);
    });
}

// student - change statut lesson "en cours"
let lessonInProgress = document.getElementById('lesson-in-progress');

if(lessonInProgress !== null){
    lessonInProgress.addEventListener("submit", 
    function(e){
        e.preventDefault();

        updateLessonStatut(lessonInProgress);
    });
}


// student - change statut lesson "terminé"
let lessonFinished = document.getElementById('lesson-finished');

if(lessonFinished !== null){
    lessonFinished.addEventListener("submit", 
    function(e){
        e.preventDefault();

        updateLessonStatut(lessonFinished);
    });
}

// teacher met une formation en ligne
let formationOnline = document.getElementById('formation-online');

if(formationOnline !== null){
    formationOnline.addEventListener("submit", 
    function(e){
        e.preventDefault();

        updateFormationOnline(formationOnline);
    });
}


// Evénement retour dernières formations
jQuery(document).ready(() => {
    $('#resultat').delegate('#enfant', 'submit', function(e){
            e.preventDefault();
            
            searchFormation(document.getElementById('enfant'));
        
    });
    /*
    $('#addSection').click(function() {
        $.ajax({
          type: "POST",
          url: url + 'controllers/ControllerAjax.php',
          data: { addSection: "2" }
        }).done(function( msg ) {
          console.log(msg);
          $('#containerSections').append(msg);
        });
      });
    */

});

