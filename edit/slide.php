<html>
    <head>
        <title>Edit Slide</title>
    </head>
    <body onload="pageLoaded();">
        <p><a href="slideshow.html">Cancel</a></p>
        <form action="/savexml.php" method="POST">
            <p><input type="file" name="background" /></p>
            <p><input type="text" name="englishtitle" id="englishtitle" value=""></input><input type="text" name="arabictitle" id="arabictitle" value=""></input></p>
            <p><textarea name="englishtext" rows="10" cols="30" id="englishtext"></textarea>
            <textarea name="arabictext" rows="10" cols="30" id="arabictext"></textarea></p>
            <p>Slide position: <input type="text" value="<?php echo $_GET['slideId']; ?>" name="slideId"></input></p>
            <p>Duration: <input type="text" value="" name="duration" id="duration"></input></p>
            <p><input type="submit" value="Save"/></p>
        </form>
        
        <script>
        
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
                        document.getElementById('duration').value = slide['@attributes'].fadetime;
                        document.getElementById("englishtitle").value = slide.english.title;
                        document.getElementById("arabictitle").value = slide.arabic.title;
                        document.getElementById("englishtext").innerHTML = slide.english.description;
                        document.getElementById("arabictext").innerHTML = slide.arabic.description;
                    }
                }
                
                //Get doc asynchronously
                xhttp.send();
            }
            
        </script>
    </body>
</html>

