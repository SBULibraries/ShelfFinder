<?php

#Sends the user to a selected image URL and stops the script's execution.
#If $debug = true we print $image. If $image is defined, we send the appropriate weblink.
# You'l have to adjust the location urls to that of your web-accessible server. 
function go($image){
    global $debug;
    global $call_number;
    if($debug){
        print $image;
    } else {
        if (is_array($image)) {
            header("Location: https://repo.stonybrook.edu/MATT/ui.php?image={$image[2]}&xp={$image[0]}&yp={$image[1]}&call=$call_number&si={$image[3]}&title=Map");
        } else {
            header("Location: https://repo.stonybrook.edu/MATT/ui.php?image=$image&call=$call_number&title=Map");
        }
    }

    exit;
}

#Normalizes the Library of Congress call number for consistent formatting and comparison.
#This function will need to be edited to account for your institution's oversize rules.
function normalize_lc($lc, &$oversize = false){
    #At Stony Brook, oversize N is interfiled. So we remove the oversize identifier.
    #This will be commented out here, but you can uncomment it if you need it. 
    #If you do, remember to change line 36 from if to elif
/*
    if (strpos($lc, 'x N') === 0) {
        $lc = substr_replace($lc, 'N', 0, 3);
    } elseif (strpos($lc, 'OVERSIZE x N') === 0) {
        $lc = substr_replace($lc, 'N', 0, 12);
    }
*/
    #For all other oversize, we set $oversize to true
    if (strpos($lc, 'x ') === 0) {
        $lc = substr_replace($lc, '', 0, 2);
        $oversize = true;
    } elseif (strpos($lc, 'X ') === 0) {
        $lc = substr_replace($lc, '', 0, 2);
        $oversize = true;
    } elseif (strpos($lc, 'OVERSIZE x ') === 0) {
        $lc = substr_replace($lc, '', 0, 10);
        $oversize = true;
    }
    $matches = array();

    #Call number order decider, formatted for LoC classification.
    #Designed by the Robot Librarian. Source: http://robotlibrarian.billdueber.com/2008/11/normalizing-loc-call-numbers-for-sorting/
    $pattern = "/^
              \s*
              ([A-Z]{1,3})  # alpha
              \s*
              (         # optional numbers
                \d+
                (?: \s*\.\s*\d+)?  # ...with optional decimal point
              )?
              \s*
              (?:               # optional cutter
                \.? \s*
                ([A-Z]+)      # cutter letter
                \s*
                (\d+)?        # cutter numbers
              )?
              (?:               # optional cutter
                \.? \s*
                ([A-Z]+)      # cutter letter
                \s*
                (\d+)?        # cutter numbers
              )?
              (?:               # optional cutter
                \.? \s*
                ([A-Z]+)      # cutter letter
                \s*
                (\d+)?        # cutter numbers
              )?
              \s*
              (.*?)            # everthing else
              \s*$
            /x";

    preg_match($pattern, $lc, $matches);

    list($lc, $alpha, $num, $c1alpha, $c1num, $c2alpha, $c2num, $c3alpha, $c3num, $extra) = $matches;
    $c1num = str_pad($c1num, 4, "0");
    $c2num = str_pad($c2num, 4, "0");
    $c3num = str_pad($c3num, 4, "0");
    if(!empty($extra)){ $extra = " $extra"; }

    return sprintf("%-3s%09.4f%-2s%4s%-2s%4s%-2s%4s%s", $alpha, $num, $c1alpha, $c1num, $c2alpha, $c2num, $c3alpha, $c3num, $extra);
}

#Determines the appropriate image file based on the given library and location codes.
function check_location($library_code, $location_code) {
    switch ($library_code) {
        case "STBMU":
            switch ($location_code) {
                #In these cases we provide a static image of the location's circulation desk.
                case "RES":
                case "PERM":
                case "AUDIO":
                    $image = "muscirc.png";
                    break;
                #These locations are handled by the array.
                case "MUS":
                case "MONU":
                case "CIRC":
                case "SSC":
                    $image = false;
                    break;
                #Else case for an unrecognized ALMA location.
                default:
                    $image = "muscirc.png";
                    break;
            }
            break;

        case "STBMN":
            switch ($location_code) {
                case "RES":
                case "CD":
                case "PERM":
                    $image = "maincirc.png";
                    break;
                case "MAIN":
                case "AV":
                case "SSC":
                    $image = false;
                    break;
                default:
                    $image = "maincirc.png";
                    break;
            }
            break;

        case "STBNR":
            switch ($location_code) {
                case "RES":
                case "RDSK":
                case "REF":
                case "PERM":
                case "PTDL":
                case "OFF":
                case "MAP":
                case "INDEX":
                case "CD-ROM":
                case "ATLAS":
                case "VGAME":
                case "UNASSIGNED":
                case "STGE":
                case "REPT":
                case "Equipment":
                case "LaptopLoan":
                case "DIS":
                case "MSREF":
                    $image = "nrrcirc.png";
                    break;
                case "THES":
                case "SCI":
                case "SSC":
                case "PER":
                    $image = false;
                    break;
                default:
                    $image = "nrrcirc.png";
                    break;
            }
            break;

        #Else case if library code is not recognized
        default:
            $image = "";
            break;
    }
    return $image;
}

#Normalizes the list of call number ranges for sorting and comparison.
function normalize_ranges($ranges){
	$normalized = [];
	foreach($ranges as $lc => $image){
		$cur = normalize_lc($lc);
		$normalized[$cur] = $image;
	}

	return $normalized;
}


#Determines the correct base image for a given call number by normalizing and comparing it against a set of ranges.
function find_image($call_number, $ranges){
	global $debug;
	$results = [
		'call_number' => $call_number,
	];

	$results['normalized_call_number'] = $call_number;

    #Stop script if call number matches a call number in the array, used that array entry.
	if(array_key_exists($call_number, $ranges)){
		if($debug){ 
            print "Location matches an end cap.\n"; }
            print "Normalized call number was: $call_number\n";
            print "Before and after values were:\n";
            var_dump($results);
    return $ranges[$call_number];
	}

	#Add the normalized number to the array.
	$ranges[$call_number] = "";

	#Sort the array, then find where our Primo call number is located.
	ksort($ranges);
	foreach($ranges as $lc => $image){
		if($image === ""){
			// The current entry is the one we're looking for.
			// Log the "previous" variable to results.
			$results['previous'] = $previous;
		} else {
			if(isset($results['previous'])){
				// The current entry is the one immediately
				// after the one we're looking for.
				// Log it as the "next" variable.
				$results['next'] = $image;
				break;
			} else {
				// We have not found the item we're looking for
				// yet.  Update the $previous variable to record
				// the one we're looking at now.
				$previous = $image;
			}
		}
	}
    #Error messaging in case something goes wrong. Likely an issue with array data, like an out of order call number.
	if($results['previous'] != $results['next']){
		if($debug){
			print "Unable to determine image.\n";
			print "Normalized call number was: $call_number\n";
			print "Before and after values were:\n";
			var_dump($results);
			print "\n";
		}
		return $results;
	}

	return $results['previous'];
        
}