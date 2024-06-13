let promise = new Promise(function (success, fail) {
  let request = new XMLHttpRequest();
  request.open("get", "http://localhost/mywork/Exams/phpFinalExam/php/fetchRecord.php");
  request.send();
  request.onload = function ()
  {
    if (request.status == 200) {
      success (request.response);
    } else {
      fail("Record Not found");
    }
  }
});
promise.then(
  function (success) {
    let jsonObj = JSON.parse(success);
    let data;
    for (let i in jsonObj) {
      data += `
      <tr>
        <td><img class="image" src="../public/uploads/${ jsonObj[i]['img'] }"></td>
        <td>${ jsonObj[i]['name'] }</td>
        <td>${ jsonObj[i]['email'] }</td>
        <td>${ jsonObj[i]['verified_email'] }</td>
        <td>${ jsonObj[i]['phone'] }</td>
        <td>${ jsonObj[i]['gender'] }</td>
        <td>${ jsonObj[i]['status'] }</td>
        <td>${ jsonObj[i]['is_approved'] }</td>
      </td>
      `;
    }
    let table = document.getElementById("n");
    console.log(table);
    table.innerHTML = data;
   },
  function (fail) { console.log(fail) }
);
