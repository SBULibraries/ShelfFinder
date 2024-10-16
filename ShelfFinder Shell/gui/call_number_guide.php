<?php 
#This needs to be brought in to display the Call Number in the pop up window.
$call_number=$_GET["call"];
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

<!-- Pop-up content -->
<div id="library-info" class="library-container color-bars-border box-type-4 box-position-1">
    <div class="box-html">
        <div class="box-title color-bars color-bars-border"></div>
        <div class="box-content clearfix">
            <!-- Call Number -->
            <p class="p2"><u>Your Call Number:</u> <?php echo($call_number);?></p>
            <!-- Close Window -->
            <button class="guideButton" onclick="toggleIframe1()">Close Window</button>
            <!-- "X" window -->
            <button class="close-button" onclick="toggleIframe1()">X</button>
            
            <!-- Content for Call Number Help Guide, update with library information -->
            <p class="p1">
                The Stony Brook University Libraries use Library of Congress call numbers in most locations, 
                except the Health Sciences Library (where National Library of Medicine classification is used). 
                The Main Stacks contains collections of journals, serials, and books for the study of numerous 
                disciplines in the humanities and social sciences. The location code MAIN refers to the materials 
                housed on the 2nd, 3rd, and 4th floors of the Main Library. The North Reading Room houses collections 
                related to science and engineering.
            </p>
            <!-- Table -->
            <table border="1" cellpadding="5" cellspacing="1" style="margin: 0 auto; line-height: 24px; text-align: center;" width="80%">
                <tbody>
                    <tr>
                        <td class="p2">First Letter of the Call Number</td>
                        <td class="p2">Floor Where the Item is Located</td>
                    </tr>
                    <tr>
                        <td class="p1">A - E</td>
                        <td class="p1">2nd floor</td>
                    </tr>
                    <tr>
                        <td class="p1">F - N</td>
                        <td class="p1">3rd floor</td>
                    </tr>
                    <tr>
                        <td class="p1">P</td>
                        <td class="p1">4th floor</td>
                    </tr>
                    <tr>
                        <td class="p1">Q - Z</td>
                        <td class="p1">3rd floor</td>
                    </tr>
                    <tr>
                        <td class="p1" colspan="2">Use the Stacks stairs on the third floor 
                                                    to get to the second and fourth floors.</td>
                    </tr>
                </tbody>
            </table>
            <!-- Resume Content -->
            <ul style="line-height: 24px;">
                <li>
                    <p class="p1">
                        All oversized books will have "x", "xx", or "xxx" indicated before the call number. 
                        Single "x" indicates oversize; "xx" indicates double oversize, and "xxx" indicates 
                        triple oversize. All oversize books are shelved at the end of the general collections 
                        on each floor, beginning with single "x". The only exception to this is that "x" N's 
                        (art books) are shelved with regular size N's. For detailed information, please consult 
                        the stacks floor maps located on the second and fourth-floor landings in the stacks stairwell. 
                        This does not apply to oversized material in Government Documents and the Reference Department, 
                        where all sizes are shelved together.
                    </p>
                </li>
                <li>
                    <p class="p1">
                        Please ask desk staff to retrieve Cage material. You will need to present staff with call number 
                        information. All Cage material must be checked out using your library ID card even when browsing 
                        the material.
                    </p>
                </li>
            </ul>
            <!-- LOC Classifications -->
            <p class="p1">
                There are 21 main Library of Congress classifications:
            </p>
            <p class="p1">
                <b>A</b> General Works<br>
                <b>B</b> Philosophy, Psychology, Religion<br>
                <b>C</b> Auxiliary Sciences of History<br>
                <b>D</b> World History and History of Europe<br>
                <b>E</b> History of the Americas<br>
                <b>F</b> History of the Americas<br>
                <b>G</b> Geography, Anthropology, Recreation<br>
                <b>H</b> Social Sciences<br>
                <b>J</b> Political Science<br>
                <b>K</b> Law<br>
                <b>L</b> Education<br>
                <b>M</b> Music<br>
                <b>N</b> Fine Arts<br>
                <b>P</b> Language and Literature<br>
                <b>Q</b> Science<br>
                <b>R</b> Medicine<br>
                <b>S</b> Agriculture<br>
                <b>T</b> Technology<br>
                <b>U</b> Military Science<br>
                <b>V</b> Naval Science<br>
                <b>Z</b> Bibliography, Library Science, Information Resources
            </p>
            
            <!-- Close button -->
            <button class="guideButton" onclick="toggleIframe1()">Close Window</button>
        </div>
    </div>
</div>
</body>
</html>