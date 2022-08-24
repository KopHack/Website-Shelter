let loginDivState = false;
let registrationState = false;
let basketDivState = false;

let userDivState = false;

let addEditDivState = false;
let editFormState = false;
let addFormState = true;

let loginDiv = document.getElementById('login-div');
let loginRef = document.getElementById('login-ref');
let loginForm = document.getElementById('login-form');
let registrationForm = document.getElementById('registration-form');
let basketDiv = document.getElementById('basket-div');
let basketRef = document.getElementById('basket-ref');

let userDiv = document.getElementById('user-div');
let userRef = document.getElementById('user-ref');

let addEditlayout = document.getElementById('add-edit');
let editForm = document.getElementById('edit-form');
let addForm = document.getElementById('add-form');

function toggleLoginForm() {
    if(loginDivState) {
        loginDiv.classList.toggle('profile-form-inactive');
        loginRef.classList.toggle('profile-form-active-ref');
        loginForm.classList.remove('profile-form-inactive');
        registrationForm.classList.add('profile-form-inactive');
        registrationState = false;
        loginDivState = false;
    } 
    else {
        loginRef.classList.toggle('profile-form-active-ref');
        loginDiv.classList.toggle('profile-form-inactive');
        loginDivState = true;
    }
}

function toggleRegistration() {
    if(registrationState) {
        loginForm.classList.toggle('profile-form-inactive');
        registrationForm.classList.toggle('profile-form-inactive');
        registrationState = false;
    }
    else {
        loginForm.classList.toggle('profile-form-inactive');
        registrationForm.classList.toggle('profile-form-inactive');
        registrationState = true;
    }
}

function toggleBasket() {
    if(basketDivState) {
        basketDiv.classList.toggle('profile-form-inactive');
        basketRef.classList.toggle('basket-form-active-ref');
        basketDivState = false;
    }
    else {
        basketDiv.classList.toggle('profile-form-inactive');
        basketRef.classList.toggle('basket-form-active-ref');
        basketDivState = true;
    }
}

function toggleUserMenu() {
    if(userDivState) {
        userDiv.classList.toggle('profile-form-inactive');
        userRef.classList.toggle('profile-form-active-ref');
        userDivState = false;
    } else {
        userDiv.classList.toggle('profile-form-inactive');
        userRef.classList.toggle('profile-form-active-ref');
        userDivState = true;
    }
}

function callAddForm() {
    $('<div id="__msg_overlay">').css({
        "width" : "100%"
        , "height" : "100%"
        , "background" : "#000"
        , "position" : "fixed"
        , "top" : "0"
        , "left" : "0"
        , "zIndex" : "50"
        , "MsFilter" : "progid:DXImageTransform.Microsoft.Alpha(Opacity=60)"
        , "filter" : "alpha(opacity=60)"
        , "MozOpacity" : 0.6
        , "KhtmlOpacity" : 0.6
        , "opacity" : 0.6
    }).appendTo(document.body);

    document.getElementById('add-edit').classList.remove('profile-form-inactive');
    document.getElementById('add-div').classList.remove('profile-form-inactive');
}

function callRequestForm() {
    $('<div id="__msg_overlay">').css({
        "width" : "100%"
        , "height" : "100%"
        , "background" : "#000"
        , "position" : "fixed"
        , "top" : "0"
        , "left" : "0"
        , "zIndex" : "50"
        , "MsFilter" : "progid:DXImageTransform.Microsoft.Alpha(Opacity=60)"
        , "filter" : "alpha(opacity=60)"
        , "MozOpacity" : 0.6
        , "KhtmlOpacity" : 0.6
        , "opacity" : 0.6
    }).appendTo(document.body);

    document.getElementById('add-edit').classList.remove('profile-form-inactive');
    document.getElementById('request-div').classList.remove('profile-form-inactive');
    document.getElementById('info-div').classList.remove('profile-form-inactive');
}

function callEditForm() {
    $('<div id="__msg_overlay">').css({
        "width" : "100%"
        , "height" : "100%"
        , "background" : "#000"
        , "position" : "fixed"
        , "top" : "0"
        , "left" : "0"
        , "zIndex" : "50"
        , "MsFilter" : "progid:DXImageTransform.Microsoft.Alpha(Opacity=60)"
        , "filter" : "alpha(opacity=60)"
        , "MozOpacity" : 0.6
        , "KhtmlOpacity" : 0.6
        , "opacity" : 0.6
    }).appendTo(document.body);

    document.getElementById('edit-div').classList.remove('profile-form-inactive');
    document.getElementById('add-edit').classList.remove('profile-form-inactive');
}

function closeEditForm() {
    $('#__msg_overlay').remove();

    document.getElementById('edit-div').classList.add('profile-form-inactive');
    document.getElementById('add-edit').classList.add('profile-form-inactive');
}

function closeAddForm() {
    $('#__msg_overlay').remove();

    document.getElementById('add-div').classList.add('profile-form-inactive');
    document.getElementById('add-edit').classList.add('profile-form-inactive');
}

function closeRequestForm() {
    $('#__msg_overlay').remove();

    document.getElementById('add-edit').classList.add('profile-form-inactive');
    document.getElementById('request-div').classList.add('profile-form-inactive');
    document.getElementById('info-div').classList.add('profile-form-inactive');
}

document.addEventListener('click', function(event) {
    if (loginRef != undefined && !loginRef.contains(event.target) && !loginDiv.contains(event.target)) {
        loginDiv.classList.add('profile-form-inactive');
        loginRef.classList.remove('profile-form-active-ref');
    }
    if (!basketRef.contains(event.target) && !basketDiv.contains(event.target)) {
        basketDiv.classList.add('profile-form-inactive');
        basketRef.classList.remove('basket-form-active-ref');
    }
    if (userRef != undefined && !userRef.contains(event.target) && !userDiv.contains(event.target)) {
        userDiv.classList.add('profile-form-inactive');
        userRef.classList.remove('profile-form-active-ref');
    }
}, true);