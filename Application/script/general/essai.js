let deleteSection = document.querySelectorAll('button.delete-section');

if(deleteSection !== null){
    console.log(deleteSection);
    for(let i=0; i < deleteSection.length; i++){
        deleteSection[i].addEventListener('click', () => {
            if(window.confirm('voulez vous vraiment supprimer cette section?')){
                console.log('I clicked!');
            }
        });
    }

}