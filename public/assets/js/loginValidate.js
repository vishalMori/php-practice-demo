function validateUser() {
  // Get elements
  let form = document.getElementById("loginForm");
  let button = document.querySelector("submit");
  let formData = new FormData(form, button);

  let ValueObject = {};
  formData.forEach((value, key) => ValueObject[key] = value);
  let jsonObject = JSON.stringify(ValueObject);

  let promise = new Promise(function (succcessMessage, errorMessage) {
    let request = new XMLHttpRequest();
    request.onload = function () {
      if (request.response == "login done") {
        succcessMessage(request.response);
        window.location = "homePage.php";
      } else {
        errorMessage(request.response);
      }
    }
    request.open("get", "../php/loginPage.php?obj=" + jsonObject);
    request.send();
  });
  promise.then(
    function (succcessMessage) {
      document.getElementById("message").innerHTML = succcessMessage;
    },
    function (errorMessage) {
      document.getElementById("message").innerHTML = errorMessage;
    }
  );
}