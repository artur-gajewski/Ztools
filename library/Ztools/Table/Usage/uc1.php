<?php

// Set the values of each displayed column as well as their title to be rendered
$columns = array("firstname" => "First name",
                 "lastname"  => "Last name",
                 "email"     => "Email address");

// Create an array of data with column names related to the column keys set above.
$rows = array(
  array("firstname" => "John",
        "lastname"  => "Doe",
        "email"     => "info@myemail.com"),
  array("firstname" => "Jack",
        "lastname"  => "Sparrow",
        "email"     => "jack@pirates.com"),
  array("firstname" => "Darth",
        "lastname"  => "Vader",
        "email"     => "masterjedi@deathstar.com"),
  array("firstname" => "Santa",
        "lastname"  => "Claus",
        "email"     => "santa@joulupukinmaa.fi")
);

// Create the object
$dataTable = new Ztools_Data();

// Set table options with various data to be used in the table
$dataTable->setColumns($columns)
          ->setClass('MyTables')
          ->setId('MyTable-1')
          ->setCount(true)
          ->setData($rows);

// Finally render the complete table HTML code
echo $dataTable->createTable();