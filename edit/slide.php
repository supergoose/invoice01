<html>
    <head>
        <title>Edit Slide</title>
        <script type="text/javascript" src="../lib/js/mousetrap.js"></script>
    </head>
    <body onload="pageLoaded();">
        <p><a href="slideshow.html">Cancel</a></p>
        <form action="/savexml.php" method="POST">
            <p>Background: <select name="background" onchange="selectedbg()" id="selectbg">
            <?php 
            
            $dir    = '../assets';
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
            <div id="textentry">
                <p><input type="text" name="englishtitle" id="englishtitle" value=""></input><input type="text" name="arabictitle" id="arabictitle" value=""></input></p>
                <p><textarea name="englishtext" rows="10" cols="30" id="englishtext"></textarea>
                <textarea name="arabictext" rows="10" cols="30" id="arabictext"></textarea></p>
                <p>Duration: <input type="text" value="" name="duration" id="duration"></input></p>
            </div>
            <p style="display:none;>Slide position: <input type="text" value="<?php echo $_GET['slideId']; ?>" name="slideId""></input></p>
            
            <p><input type="submit" value="Save"/></p>
        </form>
        
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
                xhttp.open("GET", "/loadxml.php?slideId=<?php echo $_GET['slideId']; ?>&t="+Math.random(), true);
                
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
                        }
                        
                        document.getElementById('duration').value = (!slide['@attributes'].fadetime)?default_values['duration']:slide['@attributes'].fadetime;
                        document.getElementById("englishtitle").value = (!slide.english.title)?default_values['englishtitle']:slide.english.title;
                        document.getElementById("arabictitle").value = (!slide.arabic.title)?default_values['arabictitle']:slide.arabic.title;
                        document.getElementById("englishtext").innerHTML = (!slide.english.description)?default_values['englishtext']:slide.english.description;
                        document.getElementById("arabictext").innerHTML = (!slide.arabic.description)?default_values['arabictext']:slide.arabic.description;
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
                window.location.href = "/run.html";
                
            });
            
        </script>
    </body>
</html>

