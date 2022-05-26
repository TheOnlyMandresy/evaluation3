const list = document.querySelectorAll('[data-id]');

if (list.length > 0) {
    const editsBtn = document.querySelectorAll('[data-edit]');
    const searchBar = document.getElementById('search');

    editsBtn.forEach(el => el.addEventListener('click', editModal));
    searchBar.addEventListener('input', research);
}

function editModal (e)
{
    let form;
    const id = e.target.dataset.edit;
    const section = document.querySelector('h1').dataset.section;
    const datas = document.querySelector('[data-id="' +id+ '"]');
    
    switch (section) {
        case 'missions':
            form = modalMission(datas);
            break;
        case 'hideouts':
            form = modalHideout(datas);
            break;
        case 'countries':
            form = modalCountry(datas);
            break;
        case 'faculties':
            form = modalFaculty(datas);
            break;
        case 'missions type':
            form = modalMissionType(datas);
            break;
        case 'agents':
            form = modalAgent(datas);
            break;
        case 'contacts':
            form = modalContact(datas);
                break;
        case 'targets':
            form = modalTarget(datas);
            break;
    }

    const box = document.createElement('div');
    const btnCancel = document.createElement('p');
    const btnDelete = form.querySelector('button').cloneNode(false);

    box.classList.add('modal');
    btnCancel.innerHTML = 'fermer';

    btnDelete.name = 'delete';
    btnDelete.classList.remove('btn-success');
    btnDelete.classList.add('btn-danger');
    btnDelete.value = id;
    btnDelete.innerHTML = 'Supprimer';

    form.querySelector('button').name = 'edit';
    form.querySelector('button').classList.remove('btn-success');
    form.querySelector('button').classList.add('btn-warning');
    form.querySelector('button').innerHTML = 'Modifier';
    form.querySelector('button').value = id;
    form.appendChild(btnDelete);
    box.appendChild(btnCancel);
    box.appendChild(form);
    document.body.style.overflow = 'hidden';
    document.body.appendChild(box);

    document.querySelector('.modal p').addEventListener('click', closeModal);
}

function closeModal ()
{
    const modal = document.querySelector('.modal');
    modal.querySelector('p').removeEventListener('click', closeModal);
    modal.remove();
    document.body.style.overflow = 'initial';
}

function autoSelect (from, form, datas)
{
    const dataset = from.split('[]')[0];
    const optionsForm = form.querySelectorAll('[name="' +from+ '"] option');
    const options = datas.querySelectorAll('[data-' +dataset+ ']');

    console.log(dataset);

    for (let x = 0; x < options.length; x++) {
        const option = options[x].dataset[dataset];
        optionsForm.forEach(el => { if (el.innerHTML === option) el.selected = true });
    }
}

function modalMission (datas)
{
    const form = document.querySelector('form').cloneNode(true);
    const selects = ['country', 'type', 'faculty', 'state', 'agents[]', 'contacts[]', 'targets[]', 'hideouts[]'];

    form.querySelector('[name="title"]').value = datas.querySelector('h3').textContent;
    form.querySelector('[name="description"]').value = datas.querySelector('.description').textContent;
    form.querySelector('[name="codeName"]').value = datas.querySelector('p[data-codename]').dataset.codename;

    form.querySelector('[name="startDate"]').value = datas.querySelector('.start').dataset.date;
    form.querySelector('[name="endDate"]').value = datas.querySelector('.end').dataset.date;

    selects.forEach(el => autoSelect(el, form, datas));

    form.querySelector('[name="startDate"]').min = null;
    form.querySelector('[name="endDate"]').min = null;

    return form;
}

function modalHideout (datas)
{
    const form = document.querySelector('form').cloneNode(true);
    
    form.querySelector('[name="code"]').value = datas.querySelector('h3').textContent;
    form.querySelector('[name="address"]').value = datas.querySelector('p[data-address]').dataset.address;
    form.querySelector('[name="type"]').value = datas.querySelector('p[data-type]').dataset.type;
    autoSelect('country', form, datas);

    return form;
}

function modalAgent (datas)
{
    const form = document.querySelector('form').cloneNode(true);
    const fullName = datas.querySelector('h3').textContent.split(' ');

    form.querySelector('[name="lastname"]').value = fullName[0];
    form.querySelector('[name="firstname"]').value = fullName[1];
    form.querySelector('[name="birth"]').value = datas.querySelector('p[data-birth]').dataset.birth;
    form.querySelector('[name="codeName"]').value = datas.querySelector('p[data-codename]').dataset.codename;
    autoSelect('faculties[]', form, datas);
    autoSelect('nationality', form, datas);

    return form;
}

function modalTarget (datas)
{
    const form = document.querySelector('form').cloneNode(true);
    const fullName = datas.querySelector('h3').textContent.split(' ');

    form.querySelector('[name="lastname"]').value = fullName[0];
    form.querySelector('[name="firstname"]').value = fullName[1];
    form.querySelector('[name="codeName"]').value = datas.querySelector('p[data-codename]').dataset.codename;
    form.querySelector('[name="birth"]').value = datas.querySelector('p[data-birth]').dataset.birth;
    autoSelect('nationality', form, datas);
    
    return form;
}

function modalContact (datas)
{
    const form = document.querySelector('form').cloneNode(true);
    const fullName = datas.querySelector('h3').textContent.split(' ');

    form.querySelector('[name="lastname"]').value = fullName[0];
    form.querySelector('[name="firstname"]').value = fullName[1];
    form.querySelector('[name="codeName"]').value = datas.querySelector('p[data-codename]').dataset.codename;
    form.querySelector('[name="birth"]').value = datas.querySelector('p[data-birth]').dataset.birth;
    autoSelect('nationality', form, datas);

    return form;
}

function modalCountry (datas)
{
    const form = document.querySelector('form').cloneNode(true);

    form.querySelector('[name="country"]').value = datas.querySelector('h3').innerHTML;
    form.querySelector('[name="nationality"]').value = datas.querySelector('p[data-nationality]').dataset.nationality;

    return form;
}

function modalFaculty (datas)
{
    const form = document.querySelector('form').cloneNode(true);
    form.querySelector('[name="name"]').value = datas.querySelector('p').innerHTML;
    return form;
}

function modalMissionType (datas)
{
    const form = document.querySelector('form').cloneNode(true);
    form.querySelector('[name="name"]').value = datas.querySelector('p').innerHTML;
    return form;
}

function research (e)
{
    const match = e.target.value.toLowerCase();

    list.forEach(el => {
        if (!el.querySelector('*:first-child').textContent.toLowerCase().includes(match)) return el.style.display = 'none';
        el.style.display = 'block';
    });
}