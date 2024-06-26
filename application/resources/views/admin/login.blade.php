<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin|AGENT LOGIN </title>
    <style>
        @import url("https://fonts.googleapis.com/css?family=Raleway:400,400i,700");
:root {
  --success-base: #1fa47c;
  --gray-base: #151618;
  --accent-tint-90: #eaf6f8;
  --gray-tint-10: #2c2d2f;
  --gray-tint-20: #444546;
  --gray-tint-40: #737374;
  --accent-base: #2fa2bd;
}
html {
  font-size: 16px;
  line-height: 1.5;
  font-family: "Raleway";
}

body {
  /* background-color: var(--gray-base); */
  display: grid;
  place-content: center;
  min-height: 100vh;
}
img {
  display: block;
  width: 100%;
  height: auto;
}

.container {
  background-color: var(--accent-tint-90);
  border: 1rem;
  padding: .5rem;
  display: grid;
  grid-template-columns: 25rem 1fr;
  align-items: center;
  height: 100vh;
/*   min-height: 50rem; */

}

.well {
  background-color: white;
  padding: 4rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-between;
  align-self: stretch;
  border-radius: .5rem;

}

h1 {
  font-size: 1.5rem;
  font-weight: 700;
  margin: 0 0 0.5em;
}

h2 {
  font-size: 1rem;
  font-weight: 200;
  margin: 0 0 0.5em;
  color: var(--gray-tint-20);
}

hggroup{
  text-align: center;
  margin-bottom: 4rem;
}

a,p {
  font-size: 0.8125rem;
}

form {
  width: 100%;
}

form > div {
  position: relative;
  margin-bottom: 2rem;
}

label {
  color: var(--gray-tint-40);
  position: absolute;
  left: 0;
  top: 0.25rem;
  transition: all 0.3s;
  cursor: pointer;
}

input {
  border: none;
  border-bottom: 1px solid var(--gray-tint-40);
  height: 2.25rem;
  width: 100%;
  outline: none;
  transition: border-color 0.3s ease;
}

input:focus {
  border-color: var(--gray-base);
}

input:focus + label,
input:valid + label{
  transform: translateY(-1.25rem);
  font-size: 0.8125rem;
  color: var(--gray-base);
}

a{
  color: var(--accent-base);
  transition: color 0.3s ease;
}
a:hover{
  color: var(--gray-base);
}

#forgot-passwd {
  display: block;
  margin-bottom: 4rem;
}

.button {
  width: 100%;
  background-color: var(--gray-base);
  appearence: none;
  border: none;
  padding: 1rem 2rem;
  color: white;
  font-size: 1rem;
  cursor: pointer;
  border-radius: 100px;
  font-weight: bold;
  transition: background-color 0.3s, transform 0.2s;

}

.button:hover {
  background-color: var(--gray-tint-10);
}
.button:active {
  transform: translate3d(3px, 3px, 0);
}

.button-loader {
  display: flex;
  gap: .25rem;
}
.button-loader > div {
  width: .8rem;
  height: .8rem;
  background-color: white;
  border-radius: 50%;
  animation: 1.2s infinite ease-in-out scaleUp;
}

.button-loader  div:nth-child(1) {
  animation-delay: -0.32s;
}
.button-loader  div:nth-child(2) {
  animation-delay: -0.16s;
}
.button {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 3.5rem;
}
.button-loader {
  display: none;

}

.button.loading .button-text {
  display: none;
}
.button.loading .button-loader{
  display: flex;
}

.button.success {
  background-color: var(--success-base);
}
.button.loading {
  cursor: wait;
}


@keyframes scaleUp{
  0%, 80%, 100%{
    transform: scale(0);
  }
  40%{
    transform: scale(1);
  }
}

    </style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

    <div class="container" style="max-width: 800px;margin:3rem auto"><div class="well">
        <x-error-msg/>
        <form action="#" method="POST">
            @csrf
          <hggroup>
            <h3>Welcome Back</h3>
            <h5>Log as Admin</h5>
          </hggroup>
          <div class="mt-4">
            <input type="text" name="email" id="login-username" required>
            <label for="login-username">Email</label>
          </div>

          <div>
            <input type="password" name="password" id="login-passwd" required>
            <label for="login-passwd">Password</label>
          </div>

          <button class=button id="btn-submit" >
            <span class="button-text">Log In</span>
            <div class="button-loader">
              <div></div>
              <div></div>
              <div></div>
            </div>

          </button>
        </form>
      </div>

        <img src="{{asset('login.jpeg')}}" style="height: 100vh;object-fit:cover">
        </div>

{{--
        <script>
            const submitButton = document.querySelector('#btn-submit');
const submitButtonText = document.querySelector('#btn-submit .button-text');

submitButton.addEventListener('click', (e) => {
  e.preventDefault();

  submitButton.classList.add('loading');

  setTimeout(() => {
    submitButton.classList.remove('loading');
    submitButton.classList.add('success');
    submitButtonText.innerHTML = 'Login Successful';
  }, 4000);

});
        </script> --}}

</body>
</html>
