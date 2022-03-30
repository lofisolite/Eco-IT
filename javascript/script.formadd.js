// compteur caractères textarea
function compteur(zoneTexte, compteur){
    document.getElementById(zoneTexte).addEventListener('keyup', 
    
    function() {
    document.getElementById(compteur).innerHTML = document.getElementById(zoneTexte).value.length;
    });
}
  
compteur('formationDescription', 'compteur1');
  

// ajout et suppression input section
let buttonAddInputSection = document.getElementById('buttonAddInputSection');
let buttonDeleteInputSection = document.getElementById('buttonDeleteInputSection');
let containerSectionInput = document.getElementById('containerSectionInput');
let inputOrderSectionTag = document.getElementsByClassName('inputOrderSection');

// disabled button supprimer section
if(inputOrderSectionTag.length <= 2){
 buttonDeleteInputSection.style.display = 'none';
} 

buttonAddInputSection.addEventListener('click', () => {
    addInputSection();
});

function addInputSection(){ 
  // compteur nombre input order
  let inputOrderSection = document.getElementsByClassName('inputOrderSection');
  let compteurSection = inputOrderSection.length;
  let newCompteurSection = compteurSection + 1;
  
  if(newCompteurSection >= 3) {
    buttonDeleteInputSection.style.display = 'block';
  }
  
    // creation element label
    let newLabelSectionTitle = document.createElement('label');
    newLabelSectionTitle.setAttribute('for', 'sectionTitle'+ newCompteurSection);
    newLabelSectionTitle.setAttribute('class', 'form-label mt-2');

    // creation input order
    let newInputSectionOrder = document.createElement('input');
    newInputSectionOrder.setAttribute('type', 'hidden');
    newInputSectionOrder.setAttribute('value', newCompteurSection);
    newInputSectionOrder.setAttribute('name', 'sectionOrder[]');
    newInputSectionOrder.setAttribute('class', 'inputOrderSection');

    // creation input title
    let newInputSectionTitle = document.createElement('input');
    newInputSectionTitle.setAttribute('type', 'text');
    newInputSectionTitle.setAttribute('class', 'form-control');
    newInputSectionTitle.setAttribute('id', 'sectionTitle' + newCompteurSection)
    newInputSectionTitle.setAttribute('name', 'sectionTitle[]');
    newInputSectionTitle.setAttribute('value', '');
    newInputSectionTitle.setAttribute('minlength', '2');
    newInputSectionTitle.setAttribute('maxlength', '60');
    newInputSectionTitle.setAttribute('required', '');

    // creation noeud texte élément label et ajout au label
    let content = document.createTextNode('Section ' + newCompteurSection + ' - titre');  
    newLabelSectionTitle.appendChild(content);

    // ajout label à la div container.
    containerSectionInput.insertAdjacentElement('beforeend', newLabelSectionTitle);
    containerSectionInput.insertAdjacentElement('beforeend', newInputSectionOrder);
    containerSectionInput.insertAdjacentElement('beforeend', newInputSectionTitle);
}

buttonDeleteInputSection.addEventListener('click', () => {
  deleteInputSection();
});

function deleteInputSection(){
  // compteur nombre input order
  let inputOrderSection2 = document.getElementsByClassName('inputOrderSection');
  let compteurSection2 = inputOrderSection2.length;
  let newCompteurSection2 = compteurSection2 - 1;

  // disabled button delete si min 2 input
  if(newCompteurSection2 <= 2){
    buttonDeleteInputSection.style.display = 'none';
   } 
  
  let lastChildren = containerSectionInput.lastElementChild;
  let previousSibling = lastChildren.previousElementSibling;
  let previousPreviousSibling = previousSibling.previousElementSibling;
  lastChildren.remove();
  previousSibling.remove();
  previousPreviousSibling.remove();
}

// ajout et suppression ressource
let buttonAddResource = document.getElementById('buttonAddResource');
let buttonDeleteResource = document.getElementById('buttonDeleteResource');
let divResource = document.getElementById('divResource');
let resourceTitleh3 = document.getElementById('resourceTitleh3');

// disabled button supprimer resource
//if(inputOrderSectionTag.length <= 2){
// }
buttonDeleteResource.style.display = 'none';


buttonAddResource.addEventListener('click', () => {
  divResource.style.display="block";
  resourceTitleh3.style.display="block";
  addResource();
});


function addResource(){
  let containerResource = document.getElementsByClassName('containerResource');

   let compteurResource = containerResource.length;
    let newCompteurResource;

    if(compteurResource === 0){
      newCompteurResource = 1;
    } else if(compteurResource <= 1){
      newCompteurResource = compteurResource += 1;
    }

    console.log(containerResource);
    console.log(newCompteurResource);
    

    buttonDeleteResource.style.display = 'block';
    
  

    // creation div contenant une ressource
    let containerRes = document.createElement('div');
    containerRes.setAttribute('class', 'containerResource');
    
    // creation titre ressource 1
    let titleRessource = document.createElement('p');
    titleRessource.setAttribute('class', 'fw-bold');


    //Creation div contenant titre et lien
    let div1 = document.createElement('div');
    div1.setAttribute('class', 'mb-3');
    div1.setAttribute('id', 'containerResourceTitle1');

    let div2 = document.createElement('div');
    div2.setAttribute('class', 'mb-3');
    div2.setAttribute('id', 'containerResourceTitle2');

    //creation paragraphe error Title
    let pErrorTitle = document.createElement('p');
    pErrorTitle.setAttribute('id', 'errorResourceTitle'+ newCompteurResource);
    pErrorTitle.setAttribute('class', 'mb-3 error-msg');

    //creation label title
    let labelTitle = document.createElement('label');
    labelTitle.setAttribute('for', 'resourceTitle'+ newCompteurResource);
    labelTitle.setAttribute('class', 'form-label');

     // creation noeud texte élément label et ajout au label
     let content1 = document.createTextNode('titre');  
     labelTitle.appendChild(content1);

    //creation input title
    let inputTitle = document.createElement('input');
    inputTitle.setAttribute('type', 'text');
    inputTitle.setAttribute('class', 'form-control');
    inputTitle.setAttribute('id', 'resourceTitle'+ newCompteurResource);
    inputTitle.setAttribute('name', 'resourceTitle'+ newCompteurResource);
    inputTitle.setAttribute('minlength', '2');
    inputTitle.setAttribute('maxlength', '100');
    inputTitle.setAttribute('required', '');

    //creation paragraphe error URL
    let pErrorURL = document.createElement('p');
    pErrorURL.setAttribute('id', 'errorResourceURL'+ newCompteurResource);
    pErrorURL.setAttribute('class', 'mb-3 error-msg');
    
    //creation label URL
    let labelURL = document.createElement('label');
    labelURL.setAttribute('for', 'resourceURL'+ newCompteurResource);
    labelURL.setAttribute('class', 'form-label');

     // creation noeud texte élément label et ajout au label
     let content2 = document.createTextNode('Lien de la ressource');  
     labelURL.appendChild(content2);

    //creation p explicatif
    let pExplicationURL = document.createElement('p');
    pExplicationURL.setAttribute('class', 'explication-msg mb-2');

    // creation noeud texte élément label et ajout au label
    let content3 = document.createTextNode('Formats acceptés : JPG/JPEG, PNG, PDF.');  
    pExplicationURL.appendChild(content3);

    //creation input title
    let inputURL = document.createElement('input');
    inputURL.setAttribute('type', 'file');
    inputURL.setAttribute('class', 'form-control');
    inputURL.setAttribute('id', 'resourceURL'+ newCompteurResource);
    inputURL.setAttribute('name', 'resourceURL'+ newCompteurResource);
    inputURL.setAttribute('accept', 'image/png, image/jpeg, application/pdf');
    inputURL.setAttribute('required', '');

    //document.body.appendChild(p);
    divResource.insertAdjacentElement('beforeend', containerRes);
    divResource.insertAdjacentElement('beforeend', titleRessource )

    containerRes.insertAdjacentElement('beforeend', div1);
    containerRes.insertAdjacentElement('beforeend', div1);

    div1.insertAdjacentElement('beforeend', pErrorTitle);
    div1.insertAdjacentElement('beforeend', labelTitle);
    div1.insertAdjacentElement('beforeend', inputTitle);

    div1.insertAdjacentElement('beforeend', pErrorURL);
    div1.insertAdjacentElement('beforeend', labelURL);
    div1.insertAdjacentElement('beforeend', pExplicationURL);
    div1.insertAdjacentElement('beforeend', inputURL);
    
}
