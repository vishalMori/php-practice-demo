$(document).ready(function () {
  $("#userInput").validate({
    rules: {
      name: {
        required: true,
        minlength: 3
      },
      surname: {
        required: true,
        minlength: 3
      },
      email: {
        required: true,
        minlength: 7
      },
      password: {
        required: true,
        minlength: 8
      },
      conPassword: {
        required: true,
        minlength: 8,
        equalTo: "#password"
      },
      phoneNumber: {
        required: true,
        minlength: 10
      }
    },
    messages: {
      name: {
        required: "Oops! you forgot to fill your name.",
        minlength: "Name at least 3 charecter."
      },
      surname: {
        required: "May be! you forgot to fill your surname.",
        minlength: "Surname at least 3 charecter."
      },
      email: {
        required: "We need your email address to contact you.",
        email: "Your email address must be in the format of name@domain.com."
      },
      password: {
        required: "you forgot to set password.",
        minlength: "password must be 8 digits."
      },
      conPassword: {
        required: "Conform password required.",
        minlength: "Conform Password must be 8 digits.",
        equalTo: "Please enter the same password as above."
      },
      phoneNumber: {
        required: "Please specify your contact.",
        minlength: "Contact number must be 10 digits."
      }
    }
  });
});