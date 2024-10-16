<?php

#This line calls the functions document and it's functions/variables.
include("functions.php");

#Setting debug to true will return text feedback instead of the maps - for troubleshooting.
$debug = false;

#These lines recieve the item info from the Primo record and name them as php variables.
#Alma can pass the following information about the title:library_code,lang_code,location_code,location_name,call_number,title 
$location_code = $_GET['location_code'] ?? false;
$library_code = $_GET['library_code'] ?? false;
$call_number = $_GET['call_number'] ?? false;
$title = $_GET['title'] ?? false;

#Defaults $image to false, then runs the check_location function from functions.
#If the function finds a location for which $image is defined, the array is not considered.
$image = false;
$image = check_location($library_code, $location_code);

#Debug/run if $image is defined at this stage.
if ($debug && $image) {
    print "Image selected based on location code.\n";
}
if ($image) { 
    go($image); 
}
#If $image is not yet defined, we consult the array.
include("shelf-array.php");

#Defaults $oversize to false.
$oversize = false;

#Normalized the Primo call number.
#If call number contains an oversize symbol/string, sets $oversize to true.
$normalized_call_number = normalize_lc($call_number, $oversize);

#Switcher that decides what $range in the array document should be used.
switch ($library_code) {
    case "STBMU":
        if ($oversize === true) {
            $ranges = $overmusranges;
        } else {
            $ranges = $musranges;
        }
        break;
    case "STBMN":
        if ($oversize === true) {
            $ranges = $overmainranges;
        } else {
            $ranges = $mainranges;
        }
        break;
    case "STBNR":
        if ($oversize === true) {
            $ranges = $overnrr_ranges;
        } else {
            $ranges = $nrr_ranges;
        }
        break;
}

#Normalizes the selected range, with the Primo call number added.
$ranges = normalize_ranges($ranges);

#Finds the correct $image based where the call number falls within the range.
$image = find_image($normalized_call_number, $ranges);

#Info for debugging. 
$xp = $image[0];
$yp = $image[1];
$background_image_url = $image[2];
if ($debug) {
    header("Content-Type: text/plain");
    print "lib code was: $library_code\n";
    print "location code was: $location_code\n";
    print "call number was: $call_number\n";
    print "normalized call number was: $normalized_call_number\n";
    print "xp was: $xp\n";
    print "yp was: $yp\n";
    print "base was: $background_image_url\n";
    print "oversize was: " . ($oversize ? 'true' : 'false') . "\n";
}

if ($debug) { 
    print "Match found.\n"; 
}
#Runs if image is defined at this stage.
go($image);