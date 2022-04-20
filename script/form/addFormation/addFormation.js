alert('hello');
// compteur caractères textarea
function compteur(zoneTexte, compteur){
    document.getElementById(zoneTexte).addEventListener('keyup', 
    
    function() {
    document.getElementById(compteur).innerHTML = document.getElementById(zoneTexte).value.length;
    });
}
document.getElementById('compteur1').innerHTML = document.getElementById('formationDescription').value.length;

compteur('formationDescription', 'compteur1');
  

// ajout et suppression input section
let buttonAddInputSection = document.getElementById('addSection');
let buttonDeleteInputSection = document.getElementById('deleteSection');
let containerSections = document.getElementById('containerSections');
let inputOrderSection = document.getElementsByClassName('inputOrderSection');


// disabled button supprimer section au début, si une seule section.
if(inputOrderSection.length === 1){
 buttonDeleteInputSection.style.display = 'none';
} 

buttonAddInputSection.addEventListener('click', () => {
    addInputSection();
});

function addInputSection(){ 
    // compteur nombre input order
    let inputOrderSection = document.getElementsByClassName('inputOrderSection');

    // compte le nombre de section avant création des input et incrémente de 1 avec newCompteurSection
    let compteurSection = inputOrderSection.length;
    let newCompteurSection = compteurSection + 1;
  
    //creation div container d'une section
    let containerSection = document.createElement('div');
    containerSection.setAttribute('id', 'containerSection'+ newCompteurSection);
    //newContainerSection.setAttribute('class', 'mb-3');

    //nbr section //
    let nbrSection = document.createElement('h4');
    nbrSection.setAttribute('id', 'nbrSection'+ newCompteurSection);
    nbrSection.setAttribute('class', 'my-4 text-center');

    let contentNbr = document.createTextNode('Section '+ newCompteurSection);  
    nbrSection.appendChild(contentNbr);

    // creation paragraphe erreur
    let paragraphErrorTitle = document.createElement('p');
    paragraphErrorTitle.setAttribute('id', 'errorSectionTitle'+ newCompteurSection);
    paragraphErrorTitle.setAttribute('class', 'mb-3 error-msg');

    // creation element label titre
    let labelSectionTitle = document.createElement('label');
    labelSectionTitle.setAttribute('for', 'sectionTitle'+ newCompteurSection);
    labelSectionTitle.setAttribute('class', 'form-label mt-2');

    // creation noeud texte élément label et ajout au label
    let contentLabelTitle = document.createTextNode('Section ' + newCompteurSection + ' - titre :');  
    labelSectionTitle.appendChild(contentLabelTitle);

    // creation input order
    let inputSectionOrder = document.createElement('input');
    inputSectionOrder.setAttribute('type', 'hidden');
    inputSectionOrder.setAttribute('value', newCompteurSection);
    inputSectionOrder.setAttribute('name', 'sectionOrder[]');
    inputSectionOrder.setAttribute('class', 'inputOrderSection');

    // creation input title
    let inputSectionTitle = document.createElement('input');
    inputSectionTitle.setAttribute('type', 'text');
    inputSectionTitle.setAttribute('id', 'sectionTitle' + newCompteurSection)
    inputSectionTitle.setAttribute('class', 'form-control sectionTitleClass');
    inputSectionTitle.setAttribute('name', 'sectionTitle[]');
    inputSectionTitle.setAttribute('value', '');
    inputSectionTitle.setAttribute('minlength', '2');
    inputSectionTitle.setAttribute('maxlength', '70');
    inputSectionTitle.setAttribute('required', '');

    //label select nombre de leçon
    let labelNbrLesson = document.createElement('label');
    labelNbrLesson.setAttribute('for', 'nbrLesson'+ newCompteurSection);
    labelNbrLesson.setAttribute('class','my-2');

    // noeud element label nombre de leçon
    let contentLabelNbrLesson = document.createTextNode('Nombre de leçon :');
    labelNbrLesson.appendChild(contentLabelNbrLesson);

    // Select nbr Lesson
    let selectNbrLesson = document.createElement('select');
    selectNbrLesson.setAttribute('id', 'nbrLesson'+ newCompteurSection);
    selectNbrLesson.setAttribute('name', 'nbrLesson[]');
    selectNbrLesson.setAttribute('class', 'nbrLesson');
    selectNbrLesson.setAttribute('required', '');

    let option0 = document.createElement('option');
    option0.setAttribute('value', '');
    option0.setAttribute('selected', '');
    let option1 = document.createElement('option');

    option1.setAttribute('value', '1');
    let un = document.createTextNode('1');
    option1.appendChild(un);

    let option2 = document.createElement('option');
    option2.setAttribute('value', '2');
    let deux = document.createTextNode('2');
    option2.appendChild(deux);

    let option3 = document.createElement('option');
    option3.setAttribute('value', '3');
    let trois = document.createTextNode('3');
    option3.appendChild(trois);

    let option4 = document.createElement('option');
    option4.setAttribute('value', '4');
    let quatre = document.createTextNode('4');
    option4.appendChild(quatre);

    let option5 = document.createElement('option');
    option5.setAttribute('value', '5');
    let cinq = document.createTextNode('5');
    option5.appendChild(cinq);

    let option6 = document.createElement('option');
    option6.setAttribute('value', '6');
    let six = document.createTextNode('6');
    option6.appendChild(six);

    let option7 = document.createElement('option');
    option7.setAttribute('value', '7');
    let sept = document.createTextNode('7');
    option7.appendChild(sept);

    let option8 = document.createElement('option');
    option8.setAttribute('value', '8');
    let huit = document.createTextNode('8');
    option8.appendChild(huit);

    let option9 = document.createElement('option');
    option9.setAttribute('value', '9');
    let neuf = document.createTextNode('9');
    option9.appendChild(neuf);

    let option10 = document.createElement('option');
    option10.setAttribute('value', '10');
    let dix = document.createTextNode('10');
    option10.appendChild(dix);

    // ajout Eléments au container de la section
    containerSection.insertAdjacentElement('beforeend', nbrSection);
    containerSection.insertAdjacentElement('beforeend', paragraphErrorTitle);
    containerSection.insertAdjacentElement('beforeend', labelSectionTitle);
    containerSection.insertAdjacentElement('beforeend', inputSectionOrder);
    containerSection.insertAdjacentElement('beforeend', inputSectionTitle);
    containerSection.insertAdjacentElement('beforeend', labelNbrLesson);
    containerSection.insertAdjacentElement('beforeend', selectNbrLesson);
  
    // ajout option au select
    selectNbrLesson.insertAdjacentElement('beforeend', option0);
    selectNbrLesson.insertAdjacentElement('beforeend', option1);
    selectNbrLesson.insertAdjacentElement('beforeend', option2);
    selectNbrLesson.insertAdjacentElement('beforeend', option3);
    selectNbrLesson.insertAdjacentElement('beforeend', option4);
    selectNbrLesson.insertAdjacentElement('beforeend', option5);
    selectNbrLesson.insertAdjacentElement('beforeend', option6);
    selectNbrLesson.insertAdjacentElement('beforeend', option7);
    selectNbrLesson.insertAdjacentElement('beforeend', option8);
    selectNbrLesson.insertAdjacentElement('beforeend', option9);
    selectNbrLesson.insertAdjacentElement('beforeend', option10);

    // ajout container de la section à la div contenant toutes les sections
    containerSections.insertAdjacentElement('beforeend', containerSection);
    
    // après création de l'input section, calcul du nombre d'input section et si c'est supérieur à 1, affiche bouton pour supprimer.
    if(inputOrderSection.length > 1) {
      buttonDeleteInputSection.style.display = 'block';
    }
}

buttonDeleteInputSection.addEventListener('click', () => {
  deleteInputSection();
});


function deleteInputSection(){
  // retire le dernier container de la div qui contient toutes les sections.
  let lastChildren = containerSections.lastElementChild;
  lastChildren.remove();

  // disabled button delete si un seul input
  if(inputOrderSection.length === 1){
    buttonDeleteInputSection.style.display = 'none';
    } 
}
