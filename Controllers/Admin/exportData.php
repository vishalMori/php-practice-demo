<?php
  require "../../vendor/autoload.php";
  require "../../config/dbConnection.php";

  use OpenSpout\Writer\XLSX\Writer;
  use OpenSpout\Writer\XLSX\Options;
  use OpenSpout\Common\Entity\Row;
  use OpenSpout\Common\Entity\Style\Style;

  $header = ['name', 'email', 'phone', 'gender', 'hobby'];
  $options = new Options();
  $writer = new Writer($options);
  $style = new Style();

  for ($i = 0; $i <= count($header); $i++) {
    $options->mergeCells($i, 1, $i, 2, 0);
  }
  for ($i = 0; $i <= count($header); $i++) {
    $options->mergeCells($i, 1, $i, 2, 1);
  }
  $style->setFontBold();
  $writer->openToBrowser('student.xlsx');
  $selectRecord = "SELECT `name`, `email`, `phone`, `gender`, `status`, `hobby` FROM `students`";
  $result = $conn->query($selectRecord);

  $activeUser = $writer->getCurrentSheet();
  $sheet = $writer->getCurrentSheet();
  $sheet->setName('Active user');
  $writer->addRow(Row::fromValues($header, $style));

  $deactiveUser = $writer->addNewSheetAndMakeItCurrent();
  $sheet = $writer->getCurrentSheet();
  $sheet->setName('Deactive user');
  $writer->addRow(Row::fromValues($header, $style));

  while ($row = $result->fetch_assoc()) {
    $values = [$row['name'], $row['email'], $row['phone'], $row['gender'], $row['hobby']];
    if ($row['status'] == 1) {
      $writer->setCurrentSheet($activeUser);
      $writer->addRow(Row::fromValues($values), $activeUser);
    } else {
      $writer->setCurrentSheet($deactiveUser);
      $writer->addRow(Row::fromValues($values), $deactiveUser);
    }
  }
  $writer->close();