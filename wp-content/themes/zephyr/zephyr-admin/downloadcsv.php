<?php
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data.csv');

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');


// fetch the data
session_start();
$optinmails = $_SESSION['zephyr_optinmails'];
foreach ( $optinmails as $row ) {
	fputcsv($output, $row);
}
?>