let promise = new Promise(function (success, fail) {
  let request = new XMLHttpRequest();
  request.open("get", "http://localhost/mywork/demoWebsite/Controllers/Admin/brodcast.php");
  request.send();
  request.onload = function ()
  {
    if (request.status == 200) {
      success (request.response);
    } else {
      fail("fail");
    }
    

  }
});
promise.then(
  function (success) {
    let jsonObj = JSON.parse(success);
    let data;
    for (let i in jsonObj) {
      data += `<option>${jsonObj[i]}</option>`;
    }
    document.querySelector(".brodcast").innerHTML = data;
   },
  function (fail) { console.log(fail) }
);
