changeVisibility = () => {
    var element = document.getElementById('icon-visibility')

    if (isVisible()) {
        element.classList.remove('icon-show')
        element.classList.add('icon-hidden')
        Array.from(document.getElementsByClassName("completed")).forEach(div => {
            div.style.display = 'none'
        })
    } else {
        element.classList.remove('icon-hidden')
        element.classList.add('icon-show')
        Array.from(document.getElementsByClassName("completed")).forEach(div => {
            div.style.display = 'block'
        })
    }

    
}

isVisible = () => {
    return document.getElementById('icon-visibility').classList.contains('icon-show')
}

editTask = id => {
    var form = document.getElementById('form-update')
    form.action = 'update/' + id
    var olddate = document.getElementById('task-date-' + id).innerHTML.split('/').reverse().join('-')
    var olddescription = document.getElementById('task-description-' + id).innerHTML
    var date = document.getElementById('modal-edit-date')
    var description = document.getElementById('modal-edit-description')

    date.value = olddate
    description.value = olddescription
}

validateCreate = () => {
    createData = document.getElementById('create-date').value
    createDescription = document.getElementById('create-description').value
    return (!empty(createData) && !empty(createDescription))
}

validateUpdate = () => {
    updateDate = document.getElementById('modal-edit-date').value
    updateDescription = document.getElementById('modal-edit-description').value
    return (!empty(updateDate) && !empty(updateDescription))
}

empty = data => {
    if (typeof (data) == 'number' || typeof (data) == 'boolean') {
        return false;
    }
    if (typeof (data) == 'undefined' || data === null) {
        return true;
    }
    if (typeof (data.length) != 'undefined') {
        return data.length == 0;
    }
    var count = 0;
    for (var i in data) {
        if (data.hasOwnProperty(i)) {
            count++;
        }
    }
    return count == 0;
}