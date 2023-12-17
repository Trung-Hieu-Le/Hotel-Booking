const login = document.getElementById('Log_in');
const signup = document.getElementById('sign_up');
const changepassword = document.getElementById('change_password');

//login - sigup
signuppage = () => {
  login.style.display = 'none';
  signup.style.display = 'flex';
  changepassword.style.display = 'none';
};
loginpage = () => {
  signup.style.display = 'none';
  login.style.display = 'flex';
  changepassword.style.display = 'none';
};
editpasswordpage = () => {
  signup.style.display = 'none';
  login.style.display = 'none';
  changepassword.style.display = 'flex';
}

//employee-user login
const btns = document.querySelectorAll('.btns');
const authsection = document.querySelectorAll('.authsection');

var slideNav = function (manual) {
  btns.forEach((btn) => {
    btn.classList.remove('active');
  });
  authsection.forEach((slide) => {
    slide.classList.remove('active');
  });

  btns[manual].classList.add('active');
  authsection[manual].classList.add('active');
};

btns.forEach((btn, i) => {
  btn.addEventListener('click', () => {
    slideNav(i);
  });
});

