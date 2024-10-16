<?php
#This file contains the array containing all of the call number ranges you want to use.
#The ranges can be end caps of shelving units, but you can get as granular as you'd like.
#We decided to use left, right, center ranges for shelving units over five bays wide.

#Base map images.
$mus = 'mus-.png';
$mainfz = 'mainfz.png';
$mainae = 'mainae.png';

#Each of the following arrays are called from the index as needed.
#Each range must have a start call number and an end call number.
#The arrays each contain a subarray with the following format:
#'Call number' => [x-coordinate on base image,y-coordinate on base image, $baseimage, 'shelfdata']
#We recommend building the array in Excel/Sheets and using concatenate to build the sub arrays.
#A call number cannot appear twice in the array, so where a call number is duplicated, we added 'c.10' to adjust the second call number.

$mainranges = [

	'AC1 .A65 1992' => [755,3331, $mainae, '1X'],
	'AC75 .H6 1969' => [755,3331, $mainae, '1X'],
	'Z8828.4 .T46' => [528,936, $mainfz, '499R'],
	'ZZ999' => [528,936, $mainfz, '499R'], 
];

$musranges = [

	'M1.A13 H4' => [759,1104, $mus, '01L'],
	'M2.C8 no.13 v.2' => [759,1104, $mus, '01L'],
	'M2.C8 no. 14' => [759,1235, $mus, '01C'],
	'M2.I885' => [759,1235, $mus, '01C'],
	'M2.J58 1965' => [759,1366, $mus, '01R'],
	'M2.M638 v.72' => [759,1366, $mus, '01R'],

];