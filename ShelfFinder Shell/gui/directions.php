<?php 

# vvv CUSTOMIZATION vvv

#Type in your email and phone number here
$email = "ill@stonybrook.edu"; // Your contact email address
$phone = "(631) 632-7115"; // Your contact phone number

#Bring in the "image" to this document so that we can change what is displayed based on the library code.
$image=$_GET["image"];
#Format email as mailto: 
$emailHTML = "<b><a href = 'mailto:$email'>$email</a></b>";

#This section allows us to print directions based on library code. 
#Make any content changes for the pop up window in these statements within the quotes using HTML syntax.
#Each statement is dependent on the map $image that is passed through. If no map is matched, the last statement will run.
#You will see 2 examples using the appropiate syntax. Please use your own information instead, or this will not work.
if ($image === "Map1.png" || $image === "Map2.png") {
    $directions = "<p class = 'p1'>The <b>EXAMPLE LOCATION 1</b> is located on the <b>1st floor</b> of the
    Library. You can find this room at the end of the long hallway outside of the Student Activities Center.
    If you need assistance navigating our libraries, you may contact any of our Circulation staff at our service desks, 
    email us at $emailHTML or call us at $phone.</p>";
    } elseif ($image === "Map3.png" || $image === "Map4.png" ||
                $image === "Map5.png" || $image === "Map6.png" || $image === "Map7.png") {
    $directions = "<p class = 'p1'>The <b>EXAMPLE LOCATION 2</b> is located on the <b>3rd floor</b> of the
    Library. You can find this library by walking up the stairs that are
    located in the Main Hallway and turning right, or using the elevators at the 
    North or South ends of the Building to the 3rd floor and following our signage. 
    If you need assistance navigating our libraries, you may contact any of our Circulation staff at our 
    service desks, email us at $emailHTML or call us at $phone.</p>";
    }
    else {
    $directions = "Oops! It doesn't appear we have any directions for this location!
    If you need assistance navigating our libraries, you may contact any of our Circulation staff at our service desks, 
    email us at $emailHTML or call us at $phone.</p>";
    }

# ^^^ CUSTOMIZATION ^^^

?>

<!-- Begin HTML !-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="javascript.js"></script>
</head>
<body>

<div id="direction-info" class="library-container color-bars-border box-type-4 box-position-1">
    <div class="box-html">
        <div class="box-title color-bars color-bars-border"></div>
        <div class="box-content clearfix">
            <p class="p2"><u>Directions:</u></p>
            <!-- Close button at the top -->
            <button class="close-button" onclick="toggleIframe2()">X</button>
            <!-- Main content with directions, as defined at the top of this document -->
            <p class="p1"><?php echo($directions); ?></p>
            <!-- Close button at the bottom -->
            <button class="guideButton" onclick="toggleIframe2()">Close Window</button>
        </div>
    </div>
</div>
</body>
</html>