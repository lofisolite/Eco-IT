// nombre de leçons
let nbrLesson = document.getElementsByClassName('lessonTitleClass').length;

// ensemble boutons addResource
let buttonsAddResource = document.querySelectorAll('.buttonAddResource');

// ensemble boutons deleteResource
let buttonsDeleteResource = document.querySelectorAll('.buttonDeleteResource');


for(let i=0; i < buttonsAddResource.length; i++){
    buttonsAddResource[i].addEventListener('click', () => {
        let id = i+1;
        document.getElementById('lesson'+id+'containerResources').style.display="block";
        document.getElementById('lesson'+id+'resourceTitleh3').style.display="block";
        addResource(id);
  });
}

for(let i=0; i < buttonsDeleteResource.length; i++){
    buttonsDeleteResource[i].addEventListener('click', () => {
        let id = i+1;
        deleteResource(id);
    });
}


function deleteResource(id){

    let inputOrderResource = document.getElementsByClassName('lesson'+id+'inputOrderResource');

    // div contenant les ressources
    let containerResources = document.getElementById('lesson'+id+'containerResources');

    // supprime le dernier élément du container.
    let lastChildren = containerResources.lastElementChild;
    lastChildren.remove();

    // disabled button delete s'il n'y a plus de ressources
    if(inputOrderResource.length === 0){
      document.getElementById('buttonDeleteResource'+id).style.display = 'none';
    } 
  }

function addResource(id){

    let inputOrderResource = document.getElementsByClassName('lesson'+id+'inputOrderResource');
  
    let compteurResource = inputOrderResource.length;
    let newCompteurResource;
    
    if(compteurResource === 0){
        newCompteurResource = 1;
        document.getElementById('buttonDeleteResource'+id).style.display = 'block';
    } else if(compteurResource >= 1){
      newCompteurResource = compteurResource + 1;
    } 

    // div contenant les ressources
    let containerResources = document.getElementById('lesson'+id+'containerResources');

    // creation div contenant une ressource
    let containerResource = document.createElement('div');
    containerResource.setAttribute('id', 'lesson'+id+'containerResource'+ newCompteurResource);
        
        
    //     input ordre    //
    let inputResourceOrder = document.createElement('input');
    inputResourceOrder.setAttribute('type', 'hidden');
    inputResourceOrder.setAttribute('value', newCompteurResource);
    inputResourceOrder.setAttribute('name', 'lesson'+id+'resourceOrder[]');
    inputResourceOrder.setAttribute('class', 'lesson'+id+'inputOrderResource' );
    
    //     nbr Ressource    //
    let nbrResource = document.createElement('h4');
    nbrResource.setAttribute('id', 'nbrResource'+ newCompteurResource);
    nbrResource.setAttribute('class', 'my-4 text-center');

    let contentNbr = document.createTextNode('Ressource '+ newCompteurResource);  
    nbrResource.appendChild(contentNbr);

    //         Titre       //

    //      paragraphe error Title    //
    let pErrorTitle = document.createElement('p');
    pErrorTitle.setAttribute('id', 'lesson'+id+'ErrorResourceTitle'+ newCompteurResource);
    pErrorTitle.setAttribute('class', 'mb-3 error-msg resourceTitleError');

    //creation label title
    let labelTitle = document.createElement('label');
    labelTitle.setAttribute('for', 'lesson'+id+'ResourceTitle'+ newCompteurResource);
    labelTitle.setAttribute('class', 'form-label');

    // creation noeud texte élément label et ajout au label
    let content1 = document.createTextNode('titre');  
    labelTitle.appendChild(content1);

        //creation input title
        let inputTitle = document.createElement('input');
        inputTitle.setAttribute('type', 'text');
        inputTitle.setAttribute('class', 'form-control ressourceTitleInputs');
        inputTitle.setAttribute('id', 'lesson'+id+'resourceTitle'+ newCompteurResource);
        inputTitle.setAttribute('name', 'resourceTitle['+(id-1)+'][]');
        inputTitle.setAttribute('minlength', '2');
        inputTitle.setAttribute('maxlength', '70');
        inputTitle.setAttribute('required', '');


        //         lien ressource       //
        //creation paragraphe error ressourceURL
        let pErrorURL = document.createElement('p');
        pErrorURL.setAttribute('id', 'lesson'+id+'errorResourceURL'+ newCompteurResource);
        pErrorURL.setAttribute('class', 'mb-3 error-msg resourceURLError');
        
        //creation label URL
        let labelURL = document.createElement('label');
        labelURL.setAttribute('for', 'lesson'+id+'resourceURL'+ newCompteurResource);
        labelURL.setAttribute('class', 'form-label');

        // creation noeud texte élément label et ajout au label
        let content2 = document.createTextNode('Lien de la ressource');  
        labelURL.appendChild(content2);

        //       paragraphe d'explication     //
        let pExplicationURL = document.createElement('p');
        pExplicationURL.setAttribute('class', 'explication-msg mb-2');

        // creation noeud texte élément label et ajout au label
        let content3 = document.createTextNode('Formats acceptés : JPG/JPEG, PNG, PDF.');  
        pExplicationURL.appendChild(content3);

        //creation input resourceURL
        let inputURL = document.createElement('input');
        inputURL.setAttribute('type', 'file');
        inputURL.setAttribute('class', 'form-control ressourceURLInputs');
        inputURL.setAttribute('id', 'lesson'+id+'resourceURL'+ newCompteurResource);
        inputURL.setAttribute('name', (id-1)+'[]');
        inputURL.setAttribute('accept', 'image/png, image/jpeg, application/pdf');
        

        //       Ajout des éléments      //
        // ajout du container de la resource au container de toutes les ressources
        containerResources.insertAdjacentElement('beforeend', containerResource);

        // Ajout éléments (label, input...) au container de la resource
        containerResource.insertAdjacentElement('beforeend', inputResourceOrder);
        containerResource.insertAdjacentElement('beforeend', nbrResource);
        // ajout input titre
        containerResource.insertAdjacentElement('beforeend', pErrorTitle);
        containerResource.insertAdjacentElement('beforeend', labelTitle);
        containerResource.insertAdjacentElement('beforeend', inputTitle);
        // ajout input url

        containerResource.insertAdjacentElement('beforeend', pErrorURL);
        containerResource.insertAdjacentElement('beforeend', labelURL);
        containerResource.insertAdjacentElement('beforeend', pExplicationURL);
        containerResource.insertAdjacentElement('beforeend', inputURL);

    }
