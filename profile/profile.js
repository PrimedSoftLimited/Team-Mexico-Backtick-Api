function _(str) {
    return document.querySelector(str);
}


const userUrl = 'http://backtick.herokuapp.com/public/api/user';
const token = localStorage.getItem('sessionToken');

axios.get(userUrl, {
    headers: {
        Authorization: token,
    }
}).then((response) => {
    let user = response.data.auth;
    _("#username").innerHTML += user.username;

}).catch((err) => {
    console.log(err.response);
    if (err.response.status == 401) {
        location.replace('../Welcome/welcome.html');
    }
});


// set preferences btn

_('#btn-settings').addEventListener('click', (e) => {
    e.preventDefault();
    _('#settings').classList.add('active');
});
_('#btn-close').addEventListener('click', (e) => {
    e.preventDefault();
    _('#settings').classList.remove('active');
});

window.addEventListener('keydown', function(event) {

    if (_('#settings').classList.contains('active') && event.keyCode === 27) {
        _('#settings').classList.remove('active');
    }
});  


// toggle password reveal

function showPwd(x, y) {

    if (_(x).classList.contains('active')) {
        _(x).innerHTML = '&#xf06e;';
        _(y).type = 'password';
        _(x).classList.remove('active')
    } else {
        _(x).innerHTML = '&#xf070;';
        _(y).type = 'text';
        _(x).classList.add('active');
    }
}


// populate input values

let user = JSON.parse(localStorage.getItem('currentUser'));

_('#fname').value = user.first_name;
_('#lname').value = user.last_name;
_('#usrname').value = user.username;
_('#email').value = user.email;
_('#phone').value = user.phone;


// phone country api 

const phone = _("#phone");
const iti = window.intlTelInput(phone, {
    hiddenInput: "full-phone",
    nationalMode: true,
    utilsScript: "../assets/apps/intl-tel-input-15.0.0/build/js/utils.js?1549804213570"
});


// change password; settings

pwd.addEventListener('mouseout', (e) => {
    const req = document.querySelectorAll('.req');

    if (pwd.value !== "") {
        req.forEach((req) => {
            req.required = true;
        })
    } else {
        req.forEach((req) => {
            req.required = false;
        })
    }
})


// submit settings

_("button[type='submit']").addEventListener('click', (e) => {
    e.preventDefault();
    
    let phony = iti.getNumber();
    let pwd = _('#pwd');
    let npwd = _('#npwd');
    let cnpwd = _('#cnpwd');
    let newData = {
        first_name: _('#fname').value,
        last_name: _('#lname').value,
        username: _('#usrname').value,
        email: _('#email').value,
        phone: phony
    }

    if (pwd.value !== "") {
        newData = Object.assign(newData, {
        current_password: pwd.value,
        password: npwd.value,
        password_confirmation: cnpwd.value
        });
    }


    axios.put(userUrl, newData, {
        headers: {
            Authorization: token,
        }
    })
    .then((response) => {
        console.log(response.data);
        console.log(newData);

    }).catch((err) => {
        console.log(err.response);
    })
});
