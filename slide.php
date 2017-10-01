<html>
    <head>
        <title>Edit Slide</title>
        <meta charset=utf-8 />
        <script type="text/javascript" src="lib/js/mousetrap.js"></script>
        <link href="lib/css/font-styles.css" rel="stylesheet">
        <link rel="stylesheet" href="lib/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="lib/js/jquery-ui/jquery-ui.css">
        <script src="lib/js/jquery.js"></script>
        <script type="text/javascript" src="lib/js/popper.min.js"></script>
        <script type="text/javascript" src="lib/js/bootstrap.min.js"></script>
        <style type="text/css">
        body{
            
            overflow-x: hidden;
        }
            .slide-title
            {
                color:#b2b2b2;
                font-size:60px;
                width:45%;
            }
            .small-text
            {
                color:#b2b2b2;
                font-size:40px;
                width:45%;
            }
            .back-icon
            {
                height:40px;
                width:40px;
                opacity:0.6;
            }
            .eng
            {
                font-family: 'Praxis Com'; font-weight: normal; font-style: normal;
            }
            
            .ara
            {
                font-family: 'Praxis Com'; font-weight: normal; font-style: normal;
            }
            
            input[type=text], textarea{
                border: 2px solid #e2e2e2;
                overflow-x: hidden;
            }
            .more-input, .more-input input, .more-input select, input[type=submit] 
            {
                text-align:right;
                font-size:30px;
                color:#626262;
            }
            
            input[type=submit]
            {
                color:#007bff;
                border-color:#007bff;
            }
          
        </style>
    </head>
    <body onload="pageLoaded();">
        <div class="container-fluid ml-5 mt-5 bg">
            <div class="row">
                <div class="col-md-11">
        <p><a href="slideshow.html"><img src='lib/svg/arrow-thick-left.svg' class='back-icon'></a></p>
        <form action="savexml.php" method="POST" class='mt-1'>
                        <div id="textentry" class='mt-1'>
                <p><input type="text" name="englishtitle" id="englishtitle" value="" class='slide-title eng' ></input>
                <textarea name="arabictitle" rows="1" cols="30" id="arabictitle" class='float-right slide-title ara' lang='ara' dir="rtl"></textarea></p>
                <p><textarea name="englishtext" rows="10" cols="30" id="englishtext" class='small-text eng'></textarea>
                <textarea name="arabictext" rows="10" cols="30" id="arabictext" class='float-right small-text ara' lang='ara' dir="rtl"></textarea></p>
                <p class='more-input'>Duration (seconds): <input type="text" value="" name="duration" id="duration" ></input></p>
                </div>
                <p class='more-input'>Background: <select name="background" onchange="selectedbg()" id="selectbg">
            <?php 
            
            $dir    = 'assets';
            $images = array_slice(scandir($dir), 2);

            $extensions = array('jpg', 'jpeg', 'png', 'mp4');
            
            foreach($images as $filename){
                
                $filename = basename($filename);
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                if(in_array($ext, $extensions))
                {
                    echo "<option value='assets/" . $filename . "'>".$filename."</option>";
                }
                
            }
            ?>
            </select>
            
            </p>
            
            <p style="display:none;">Slide position: <input type="text" value="<?php echo $_GET['slideId']; ?>" name="slideId"></input></p>
            
            <p><input type="submit" value="Save" class="float-right"/></p>
        </form>
        </div>
        </div>
        </div>
        <script>
        
        var default_values = {
            'duration' : 5.0,
            'englishtitle' : 'Enter English title',
            'arabictitle' : 'Enter Arabic title',
            'englishtext' : 'Enter English description',
            'arabictext' : 'Enter Arabic description'
        };
        
            //Run on page load complete
            function pageLoaded()
            {
                console.log("Page loaded");
                
                //Get the XML
                var xhttp = new XMLHttpRequest();
                xhttp.open("GET", "loadxml.php?slideId=<?php echo $_GET['slideId']; ?>&t="+Math.random(), true);
                
                //When we have received data
                xhttp.onreadystatechange = function()
                {
                    //Check was successful
                    if(this.readyState == 4 && this.status == 200)
                    {
                        console.log(this.responseText);
                        var slide = JSON.parse(this.responseText); //parse it into a JS array of objects
                        
                        var file_options = [].slice.call(document.getElementsByTagName('option'));
                        
                        var selected_file = file_options.filter(function(option){
                            return (option.value.indexOf(slide.background) > -1);
                        })[0];
                        
                        if(selected_file){
                            selected_file.setAttribute('selected','selected');
                            toggleText(slide.background);
                        } //bug here
                        
                        document.getElementById('duration').value = (!slide['@attributes'].fadetime)?default_values['duration']:slide['@attributes'].fadetime;
                        document.getElementById("englishtitle").value = (!slide.english.title)?default_values['englishtitle']:slide.english.title;
                        document.getElementById("arabictitle").innerHTML = (!slide.arabic.title)?default_values['arabictitle']:slide.arabic.title;
                        document.getElementById("englishtext").innerHTML = (!slide.english.description)?default_values['englishtext']:slide.english.description.replace(/<br\s*[\/]?>/gi, "");
                        document.getElementById("arabictext").innerHTML = (!slide.arabic.description)?default_values['arabictext']:slide.arabic.description.replace(/<br\s*[\/]?>/gi, "");
                    }
                }
                
                //Get doc asynchronously
                xhttp.send();
            }
            
            function selectedbg()
            {
                toggleText(document.getElementById('selectbg').value);
                
            }
            
            //Pass me a filename
            function toggleText(filename)
            {
                var vid_extensions = ['mp4'];
                var file_extension = filename.split('.').pop();
                if(vid_extensions.indexOf(file_extension) > -1)
                {
                    document.getElementById('textentry').style.display = 'none';
                }else{
                    document.getElementById('textentry').style.display = 'block';
                }
            }
            
            //If the user presses space we need to navigate to our edit mode
            Mousetrap.bind('space', function(e) {
                window.location.href = "run.html";
                
            });
            
        </script>
        
    </body>
</html>

