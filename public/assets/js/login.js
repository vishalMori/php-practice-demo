$(document).ready(function () {
  $("#loginForm").validate({
    rules: {
      email: { required: true },
      password: { required: true, minlength: 8 }
    },
    messages: {
      email: { required: "Enter email or username" },
      password: {
        required: "Password required for login",
        minlength: "password must be 8 digits"
      }
    }
  });
});