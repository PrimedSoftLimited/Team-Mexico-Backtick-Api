function _(str) {
    return document.querySelector(str);
}

const items = document.querySelectorAll('.char');
const links = document.querySelectorAll("a[href='#'] span");


// animate random letters

function animaterandom() {
intervalrandom = setInterval(() => {
    let i = Math.floor(Math.random() * 100);
    if (i > 84) {
    i-=15;
    }
    items[i].classList.add('animate');
    items[i].addEventListener("animationend", () => {
    items[i].classList.remove('animate');
    })
}, 5000);
};


// clear animation on random letters

function clear() {
    clearInterval(intervalrandom);  
}


// IIFE to animate links

(function animatelinks() {

    interval = setInterval(() => {
        clear();
        links.forEach((e) => { 
        e.classList.add('animated', 'flash');
        e.addEventListener("animationend", () => {
            e.classList.remove('animated', 'flash');
        })
        });
    }, 10000);
    animaterandom();
})();


// event listeners to animate letters on mouseenter, and end animation

items.forEach((e) => {
    e.addEventListener("animationend", () => {
        e.classList.remove('animate');
    })
})

items.forEach((e) => {
    e.addEventListener('mouseover', () => {
        e.classList.add('animate');
    })
})


// call registration api

function addUser(iti) {

    let username = _('#user').value;
    let email = _('#reg-email').value;
    let phony = iti.getNumber();
    let pwd = _('#reg-pwd').value;
    let cpwd = _('#reg-pwd-confirm').value;
    let user = {
        username: username,
        email: email,
        phone: phony,
        password: pwd,
        password_confirmation: cpwd
    }
    let url = 'http://backtick.herokuapp.com/public/api/register';

    axios.post(url, user).then((response) => {
        console.log(response.data);
        const token = "Bearer " + response.data.user.api_token;
        localStorage.setItem('sessionToken', token);
        location.replace('../dashboard/dashboard.html');
    }).catch((err) => {
        console.log(err.response);
    });
}


// call login api

function logUser() {

    let email = _('#login-email').value;
    let pwd = _('#login-pwd').value;
    let user = {
        email: email,
        password: pwd
    }
    let url = 'http://backtick.herokuapp.com/public/api/login';
    
    axios.post(url, user)
    .then((response) => {
        const token = "Bearer " + response.data.token;

        localStorage.setItem('sessionToken', token);
        location.replace("../dashboard/dashboard.html");
    }).catch((err) => {
        console.log(err.response);
    });
}


// show login form

function loginUI() {
    _('.form').innerHTML = `<div class="logo">
            <span class="logo-text">B</span> 
            <span class="logo-text">A</span> 
            <span class="logo-text">C</span> 
            <span class="logo-text">K</span> 
            <span class="logo-text">T</span> 
            <span class="logo-text">I</span> 
            <span class="logo-text">C</span> 
            <span class="logo-text">K</span>
        </div>
        <div class="wrapper-login">
            <h1 id="login-head">
                Login to unlock potential
            </h1>
            
            <input id="login-email" name="login-email" type="email" value="" placeholder="Email" required>

            <input id="login-pwd" name="login-pwd" type="password" value="" placeholder="Password" required>
            
            <input id="login-btn" type="submit" value="Continue">

            <small class="small-text">
                Not a member? <a href="#">Get an account</a>
            </small>
        </div>
        <small id="bottom">
            a venture by the fine fellas at team mexico. drink responsibly 🍺 ♠
        </small>`
        
    if (!(_('.wrapper-login').classList.contains('active'))) {
        _('.form').addEventListener('submit', logUser);
    }

    // link to signup
    _('.wrapper-login a').addEventListener('click', () => {
        signUpUI();
    })
}


// show signUp form

function signUpUI() {
    _('.form').innerHTML = `<div class="logo">
            <span class="logo-text">B</span> 
            <span class="logo-text">A</span> 
            <span class="logo-text">C</span> 
            <span class="logo-text">K</span> 
            <span class="logo-text">T</span> 
            <span class="logo-text">I</span> 
            <span class="logo-text">C</span> 
            <span class="logo-text">K</span>
        </div>
        <div class="wrapper-signup">
            <h1 id="login-head">
                Signup to unlock potential
            </h1>
            <small class="small-text">
                // Access Backtick with a free account
            </small>
            
            <input id="user" name="usr" type="text" placeholder="Username" required>

            <input id="reg-email" name="reg-email" type="email" placeholder="Email" required>

            <input id="reg-phone" name="reg-phone" type="tel" placeholder="" required>

            <input id="reg-pwd" name="reg-pwd" type="password" placeholder="Password" required>

            <input id="reg-pwd-confirm" name="reg-pwd-confirm" type="password" placeholder="Confirm password" required>
            
            <input id="reg-btn" type="submit" value="Continue">
            <small class="small-text">
                Already a member? <a href="#">Login</a>
            </small>
        </div>
        <small id="bottom">
            a venture by the fine fellas at team mexico. drink responsibly 🍺 ♠
        </small>`

    let phone = _("#reg-phone");

    // init intl phone api
    let iti = window.intlTelInput(phone, {
        hiddenInput: "full-phone",
        nationalMode: true,
        utilsScript: "../assets/apps/intl-tel-input-15.0.0/build/js/utils.js?1549804213570"
    });

    if (!(_('.wrapper-signup').classList.contains('active'))) {
        _('.form').addEventListener('submit', () => {
            addUser(iti);
        });
    }

    // link to login
    _('.wrapper-signup a').addEventListener('click', () => {
        loginUI();
    })    
}


// link to login form

_('#link-login').addEventListener('click', () => {

    _('#con-flex').classList.add('active');
    loginUI();
    _('.form').classList.add('active', 'animated', 'fadeIn');
    _('.form').addEventListener("animationend", () => {
        _('.form').classList.remove('animated', 'fadeIn');
    })
})


// link to signup form

_('#link-signup').addEventListener('click', () => {

    _('#con-flex').classList.add('active');
    signUpUI();
    _('.form').classList.add('active', 'animated', 'fadeIn');
    _('.form').addEventListener("animationend", () => {
        _('.form').classList.remove('animated', 'fadeIn');
    })
})

window.addEventListener('keydown', () => {

    if (_('#con-flex').classList.contains('active') && event.keyCode === 27) {
        _('.form').classList.remove('active');
        _('#con-flex').classList.remove('active');
    }
});  

