function markasread(id)
{
  let request = new XMLHttpRequest();
  request.open("put", "../../Controllers/Notifications.php");
  request.setRequestHeader('Content-Type','application/json');
  request.send(JSON.stringify({ 'id': id }));
  request.onload = function ()
  {
    window.location.reload();
  }
}