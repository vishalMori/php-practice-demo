function approveUser(enrollment)
{
  let info = {opretion: "approve", id: enrollment}
  let jsonObj = JSON.stringify(info);
  let promise = new Promise(function (resolve) {
    let request = new XMLHttpRequest();
    
    request.open("post", "../../Controllers/Admin/opretion.php");
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded", true);
    request.send("obj=" + jsonObj);
    request.onload = function ()
    {
      if (request.status == 200) {
        resolve(request.response);
      }
    }
  });
  promise.then(
    function (resolve) { console.log(resolve); }
  );
}

function permission(status, id)
{
  let getStatus = status;
  let getId = id;
  let value = { status: getStatus, id: getId }
  let jsonObj = JSON.stringify(value);

  let request = new XMLHttpRequest();
  request.onload = function ()
  {
    if (request.status == 200) {
      console.log(request.response);
    }
  }
  request.open("get", "../../Controllers/Admin/permision.php?obj="+jsonObj);
  request.send();
}

//Delete user
function deleteStudent(enrollment, email) {
  let data = {
    enrollment: enrollment,
    email : email
  }
  let jsonObj = JSON.stringify(data);
  let promise = new Promise(function (resolve, reject) {
    let request = new XMLHttpRequest();
    request.open("DELETE", "../../Controllers/Admin/deleteStudent.php?obj=" + jsonObj);
    request.send();
    request.onload = function () {
      if (request.status == 200) {
        resolve(request.response);
      } else {
        reject("Connection Error");
      }
    }
  });
  promise.then(
    function (resolve) { console.log(resolve) },
    function (reject) { console.log(reject) },

  );
}
