Authors:
Matthew Hartman (Stony Brook University)
Timothy Kohn (Stony Brook University)
Foundational Codebase Authors:
Will Martin (University of North Dakota)
Rebecca Brown (University of North Dakota)


The ShelfFinder codebase was created by Matthew Hartman (Head of Resource Sharing) 
and Timothy Kohn (Resource Sharing Coordinator) of Stony Brook University. The foundational
code was written by Will Martin and Rebecca Brown of the University of North Dakota, but has been
significantly adapted for use by Stony Brook University. ChatGPT and other LLMs were used to improve code. 

Major adaptations include:
    -A python based system for layering a locator on a base stack map.
    -A subarray methodology for passing information to the html page.
    -Switchers for use with multiple ALMA libraries.
    -Functionality for handling oversize items and other materials that aren't 'in order' so to speak.
    -A redesigned front end with css and javascript. 

Any questions about this code can be sent to ill@stonybrook.edu

BEFORE ANY OF THIS:
    1- Weed and shift your collection. Trust us.
    2- Prepare your maps and other associated images you want to use (whether you download them or create them).
    3- Prepare your shelving unit data in a spreadsheet. Email us at ill@stonybrook.edu if you need our template.
    4- Update your shelf labeling in your library locations.

HOW TO GET STARTED (a quick read-through of the code will also be helpful):
    1- Move the full codebase to a web-accessible server go that Primo can reach the index.php file. 
    2- Enable the ALMA Integration Profile in your ALMA Config, with the url pointing to the index file location.
        Something along these lines: https://fakewebsite.com/index.php?location_code={location_code}&call_number={call_number}&library_code={library_code}
    3- Place all images you would like to use in the images folder.
    4- Go to the shelf-array.php and define your map images.
    5- List your call number data following the example structure in shelf-array.php.
    6- Go to index.php and input your location code information and define what arrays they will refer to (beginning at line 38).
    7- Go to functions.php and change the website to your ALMA Integration Profile's configuration. 
        Continue to input your location codes to ensure the appropiate maps are called (beginning at line 94).
    8- Go to ui.php and fill in the sections towards the top. 
    9- Go to styles.css and change the top options to fit your brand toolkit.
    10- Go to directions.php and update directions based on maps you have uploaded.
    11- Review call_number_guide.php and update the information to be relevant to your collection (beginning at line 28).
    12- Email us at ill@stonybrook.edu if you need any help. 
