<?php
  require "../../vendor/autoload.php";
  require "../../config/dbConnection.php";
  
  use Dompdf\Dompdf;
  try {
    $data = "
      <html>
        <head>
            <style>
              body {
                font-family: Helvetica;
                font-size:10px;
              }
              table {
                border-collapse: collapse;
              }
            </style>
        </head>
        <body>
        <table width='100%' border='1px solid #000'>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Gender</th>
          <th>Status</th>
          <th>Approved ?</th>
          <th>Hobby</th>
        </tr>
    ";
    $selectRecord = 'SELECT `name`, `email`, `phone`, `gender`, `status`, `is_approved`, `hobby` FROM `students`';
    $result = $conn->query($selectRecord);
    $selectImage = "SELECT `img` FROM `images`";
    $selected = $conn->query($selectImage);
    while ($row = $result->fetch_assoc()) {
      $status = ($row["status"]) ? "Active" : "Deactive";
      $approved = ($row["is_approved"]) ? "Approved" : "Not approved";
      $data .= "
      <tr>
        <td>".$row["name"]."</td>
        <td>".$row["email"]."</td>
        <td>".$row["phone"]."</td>
        <td>".$row["gender"]."</td>
        <td>".$status."</td>
        <td>".$approved."</td>
        <td>".$row["hobby"]."</td>
      </tr>
      ";
    }
    $data .= "
        </table>
      </body>
    </html>
    ";
    $pdf = new Dompdf();
    $pdf->loadHtml($data);
    $pdf->setPaper('A4', 'portrait');
    $pdf->render();
    $pdf->getCanvas()
    ->get_cpdf()
    ->setEncryption('123', '123', ['print', 'modify', 'copy', 'add']);
    $pdf->stream('listOfUsers');
  } catch (Exception $e) {

  }

?>