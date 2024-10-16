<?php

# vvv CUSTOMIZATION vvv

# Your Contact Information
$email = "YOUR EMAIL HERE"; // Your contact email address
$phone = "YOUR PHONE NUMBER HERE"; // Your contact phone number
$notification_email = "ANOTHER EMAIL HERE"; // Where you want emails sent for errors

# Image Paths 
$background_image_url_base = "YOUR WEBSITE OR FILE PATH HERE"; // identify the path to your image folder

# Define images here
$icon_image_url = $background_image_url_base . "arrowbook.png"; // Locator icon image
$left_shelf_image_url = $background_image_url_base . "leftshelf.png"; // Example Shelf Image (Left)
$center_shelf_image_url = $background_image_url_base . "centershelf.png"; // Example Shelf Image (Center)
$right_shelf_image_url = $background_image_url_base . "rightshelf.png"; // Example Shelf Image (Right)
$xshelf_image_url = $background_image_url_base . "xshelf.png"; // Example Shelf Image (Full)

# ^^^ CUSTOMIZATION ^^^

# Image HTML for displaying on Webpage
$leftshelf = "<p class='exampleShelf' id='exampleShelf'><img id='shelfimg' alt='Sorry, there does not seem to be an example of this shelf.' title='You will find this item towards the left side of the shelf.' style='display:inline;' src='$left_shelf_image_url' loading='lazy'></p>";
$centershelf = "<p class='exampleShelf' id='exampleShelf'><img id='shelfimg' alt='Sorry, there does not seem to be an example of this shelf.' title='You will find this item towards the center of the shelf.' style='display:inline;' src='$center_shelf_image_url' loading='lazy'></p>";
$rightshelf = "<p class='exampleShelf' id='exampleShelf'><img id='shelfimg' alt='Sorry, there does not seem to be an example of this shelf.' title='You will find this item towards the right side of the shelf.' style='display:inline;' src='$right_shelf_image_url' loading='lazy'></p>";
$xshelf = "<p class='exampleShelf' id='exampleShelf'><img id='shelfimg' alt='Sorry, there does not seem to be an example of this shelf.' title='You will find this item somewhere on this shelf.' style='display:inline;' src='$xshelf_image_url' loading='lazy'></p>";
$locator_icon = "<img id='locatorimg' alt='Locator Icon' title='Locator Icon' style='display:inline;' src=$icon_image_url width='30' height='30'>";

# Initialize variables from GET parameters
$xp = $_GET["xp"];
$yp = $_GET["yp"];
$si = $_GET["si"];
$image = $_GET["image"];
$call_number = $_GET["call"];

# Map image generation
$background_image_url = $background_image_url_base . $image;

# Error message initialization
$error_message = '';
$num = (int)$si;
$lrcx = substr($si, -1);

# Image processing logic (Python script calls)
if (strpos($image, 'circ') === false) {
    $cmd = "python imgbuilder.py $background_image_url $icon_image_url 1 $xp $yp";
    $image_url = shell_exec($cmd);
} else {
    $image_url = $background_image_url;
}

# Python cover finder logic
if (!empty($call_number)) {
    $callnumber_escaped = escapeshellarg($call_number);
    $command = "python coverfinder.py $callnumber_escaped";
    $output = shell_exec($command);
    $cover = trim($output);
}

# Logic for determining shelf and position
if ($num == "non") {
    $position = "<p class='p1'>Please refer to the locator icon $locator_icon for details on where you 
            can find this item.<br>If you need any help finding this item, please ask at the circulation desk.</p>";
} elseif ($lrcx == "L") {
    $position = "<p class='p1'>You will find this item on the left side of shelf number $num.</p>";
    $shelfimg = $leftshelf;
} elseif ($lrcx == "C") {
    $position = "<p class='p1'>You will find this item towards the center of shelf number $num.</p>";
    $shelfimg = $centershelf;
} elseif ($lrcx == "R") {
    $position = "<p class='p1'>You will find this item on the right side of shelf number $num.</p>";
    $shelfimg = $rightshelf;
} elseif ($lrcx == "X") {
    $position = "<p class='p1'>You will find this item on a shelving unit numbered $num.</p>";
    $shelfimg = $xshelf;
} else {
    $position = "<p class='p1'>You will need to ask a circulation staff member for this item.</p>";
}

# If shelf number is not 0, include locator phrase and shelf image
if ($num != 0) {
    $shelfnum = "<p class='shelf-number'><u>Shelf Number:</u> $num</p>";
    $locator_phrase = "<p class='p1'>You will find your book where the $locator_icon is located.</p>";
    $description = "$locator_phrase $position $shelfimg";
} else {
    $shelfnum = "";
    $locator_phrase = "";
    $description = "$position";
}
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

<!-- If you have a Google tag (gtag.js) for analytics purposes, paste the code here -->



<body>

<!-- Here is the main webpage HTML, beginning with the Left Page (the map) in a zoom container !-->
    <div class="zoom-container">
      <div class="left-page" id="leftPage">

<!-- This PHP will either display the map, or an error message if a map is not correctly loaded !-->
      <?php if (empty($image_url)) {
        $error_message = "This map is currently unavailable. <br></br>Please visit the circulation desk <br></br>
        or email <a href='mailto:$email'>$email</a> <br></br>for assistance.";
        
                // Send an email notification
        $to = $notification_email;
        $subject = "Primo Maps Error $call_number";
        $message = "The image with the call number $call_number did not load correctly. C'monnn guys.";
        $headers = 'From: ShelfFinderErrors' . "\r\n" .
                'Reply-To: ' . $notification_email . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
        
        mail($to, $subject, $message, $headers);
        }
        if (empty($error_message)) {
          echo '<img id="mapimg" src="' . $image_url . '" alt="' . $call_number . '">';
        } else {
          echo '<p class="p2">' . $error_message . '</p>';
        } ?>
      </div>
    </div>

<!-- This is the Right Page with Call Number Information and more !-->
    <div class="right-page shown" id="collapsibleRightPage">  
        <div>
        <!-- This section at the top contains the book cover, call number, and shelf number !-->     
        <div class="bookContainer">
            <div class="BookCover">
                <br>
                <img alt=""
                    id="bookCoverImage" 
                    title="Book Cover" 
                    src="<?php echo $cover;?>" 
                    loading="lazy"
                    style="max-width: 150px; max-height: 150px; width: auto; height: auto; object-fit: contain;">            
                </div>
            <div class="bookInfo" id="bookInfo">
            <br>
                <p style="font-family: 'Effra', 'Montserrat', Times, sans-serif;
                        font-size: clamp(20px, 2vw, 24px);
                        font-weight: bold;
                        margin-bottom: 5px;"><u>Call Number:</u> <?php echo($call_number);?></p>
                <?php echo($shelfnum);?></p>
            </div>
        </div>
        <!-- This displays the description based on the variables above !-->
        <?php echo $description;?>

    <!-- Clicking on these buttons will display the pop ups for Call Number Help Guide and Directions (see separate documents) !-->
            <p class="p1">Need help? Here are some resources:<br>
                <b><a href="#iframeContainer1" onclick="toggleIframe1()">Call Number Guide</a></b><br>
                <b><a href="#iframeContainer2" onclick="toggleIframe2()">Directions to Library</a></b></p>
            <p class="p1">For further assistance, please contact us at 
                <b><a href="mailto:<?php echo($email);?>"><?php echo($email);?></a></b> or call us at <?php echo($phone);?>.</p>
        </div>
    </div>

<!-- These control the buttons for toggling the Right Page. Buttons for full window, vertical bar for mobile !-->
<div class="verticalBar" id="verticalBar" onclick="toggleRightPage()" 
    alt="Toggle More Information" title="Toggle More Information">
    <div class="verticalText" id="verticalText">
        <span>I</span>
        <span>n</span>
        <span>f</span>
        <span>o</span>
        <span>r</span>
        <span>m</span>
        <span>a</span>
        <span>t</span>
        <span>i</span>
        <span>o</span>
        <span>n</span>
    </div>
</div>

<!-- This displays the toggle buttons to Show / Hide the right page !-->
    <button class="toggleButton" id="showButton" style="display: none;" onclick="showRightPage()" 
        alt="Show Call Number Information" title="Show Call Number">Show Call Number</button>
    <button class="toggleButton" id="hideButton" onclick="hideRightPage()" 
        alt="Hide Call Number Information" title="Hide Call Number">Hide Call Number</button>

<!-- This section is the webpage and styling for the Call Number Help Guide pop-up window. !-->
<div id="iframeContainer1">
    <div><?php include "call_number_guide.php"; ?></div>
</div>

<!-- This section is the webpage and styling for the Directions pop-up window. !-->
<div id="iframeContainer2">
        <div><?php include "directions.php"; ?></div>
</div>

</body>
</html>