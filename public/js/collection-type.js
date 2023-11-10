const addParticipantFormDeleteLink = (item) => {
    const removeFormButton = document.createElement('button');
    removeFormButton.innerText = 'Supprimer le participant';
    removeFormButton.style.color = "black";
    removeFormButton.style.backgroundColor = "red";

    item.append(removeFormButton);

    removeFormButton.addEventListener('click', (e) => {
        e.preventDefault();
        // remove the li for the tag form
        item.remove();
    });
}

const addFormToCollection = (e) => {
    const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);
console.log(collectionHolder)
    const item = document.createElement('li');

    item.innerHTML = collectionHolder
        .dataset
        .prototype
        .replace(
            /__name__/g,
            collectionHolder.dataset.index
        );

    collectionHolder.appendChild(item);

    collectionHolder.dataset.index++;

    addParticipantFormDeleteLink(item);
};

document.querySelectorAll('.add_item_link')
    .forEach(btn => {
        console.log('ok');
        btn.addEventListener("click", addFormToCollection)
    });

console.log(document.querySelectorAll('ul.participants li'));
document
    .querySelectorAll('ul.participants li')
    .forEach((participant) => {
        console.log('coucou');
        addParticipantFormDeleteLink(participant)
    });


    const addSportFormDeleteLink = (item) => {
        const removeFormButton = document.createElement('button');
        removeFormButton.innerText = 'Supprimer le sport';
        removeFormButton.style.color = "black";
        removeFormButton.style.backgroundColor = "red";
    
        item.append(removeFormButton);
    
        removeFormButton.addEventListener('click', (e) => {
            e.preventDefault();
            // remove the li for the tag form
            item.remove();
        });
    }
    
    const addFormToCollection1 = (e) => {
        const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);
    console.log(collectionHolder)
        const item = document.createElement('li');
    
        item.innerHTML = collectionHolder
            .dataset
            .prototype
            .replace(
                /__name__/g,
                collectionHolder.dataset.index
            );
    
        collectionHolder.appendChild(item);
    
        collectionHolder.dataset.index++;
    
        addSportFormDeleteLink(item);
    };
    
    document.querySelectorAll('.add_item_link1')
        .forEach(btn => {
            // console.log('ok');
            btn.addEventListener("click", addFormToCollection1)
        });
    
    console.log(document.querySelectorAll('ul.sports li'));
    document
        .querySelectorAll('ul.sports li')
        .forEach((sport) => {
            // console.log('coucou');
            addSportFormDeleteLink(sport)
        })