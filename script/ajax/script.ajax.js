
// Evénement recherche formation par mot clef
document.getElementById('form-search').addEventListener("submit", 
function(e){
    e.preventDefault();

    let request = new XMLHttpRequest();
    let data = new FormData(this);
    let divResultat = document.getElementById('resultat');
    
    request.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            divResultat.innerHTML = '';
            divResultat.innerHTML = this.responseText;
        } else if(this.readyState == 4){
            alert('une erreur est survenue, veuillez réessayer');
        } 
    }

    request.open('POST', './controllers/ControllerAjax.php', true);

    request.send(data);
});

// Evénement retour dernières formations

  
//if(document.getElementById('backButton') !== null){
  
//parent du bouton
let divResult = document.getElementById('resultat');
let enfant = 

jQuery(document).ready(() => {
    $('#resultat').delegate('#enfant', 'submit', function(event){
       
            event.preventDefault();
            
            let request = new XMLHttpRequest();
            let data = new FormData(this);
            let divResultat = document.getElementById('resultat');
                
            request.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200){
                        divResultat.innerHTML = '';
                        divResultat.innerHTML = this.responseText;
                    } else if(this.readyState == 4){
                        alert('une erreur est survenue, veuillez réessayer');
                    } 
                }
    
            request.open('POST', './controllers/ControllerAjax.php', true);
    
            request.send(data);
           
        
    })

});
    

/*
divResult.addEventListener('click', function(e){
    let initElem = e.target;
    if(initElem.id === 'enfant'){
            console.log('nope');
            initElem.preventDefault();
        initElem.addEventListener("submit", function(e){
       
            let request = new XMLHttpRequest();
            let data = new FormData(this);
            let divResultat = document.getElementById('resultat');
                
            request.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200){
                        divResultat.innerHTML = '';
                        divResultat.innerHTML = this.responseText;
                    } else if(this.readyState == 4){
                        alert('une erreur est survenue, veuillez réessayer');
                    } 
                }
    
        request.open('POST', './controllers/ControllerAjax.php', true);
    
        request.send(data);

    });
        
    }
});

/*
backButton.addEventListener("submit", function(e){
       
        console.log('nope');
        e.preventDefault();

        let request = new XMLHttpRequest();
        let data = new FormData(this);
        let divResultat = document.getElementById('resultat');
            
        request.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    divResult.innerHTML = '';
                    divResult.innerHTML = this.responseText;
                } else if(this.readyState == 4){
                    alert('une erreur est survenue, veuillez réessayer');
                } 
            }

    request.open('POST', './controllers/ControllerAjax.php', true);

    request.send(data);
       

});
*/

