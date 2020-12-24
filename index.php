<?php
    /* options */
    $CACHEPATH = ".files_cached/cached.json";
    $splash = true;


    //grab file GET
    $file = array_key_exists("file", $_GET) ? $_GET["file"] : NULL;

    /* Caching Stuff™ */
    //get/save json from/to cache file
    function grabJSON(){
        global $CACHEPATH;
        return json_decode(file_get_contents($CACHEPATH), true);
    }
    function putJSON($assoc){
        global $CACHEPATH;
        file_put_contents($CACHEPATH, json_encode($assoc, JSON_PRETTY_PRINT));
    }
    $wascached = true; //used for footer
?>

<html>
    <head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" type="text/css" href="mdwv.css"\>
        <title><?=$_GET["file"] ? $_GET["file"] : "mdwv"?></title>
    </head>
    <body>
        <div align="center" class="md_divbody">
            <div class="md_divcontent">
                <?php
                    // if no file given, show list of files in file directory
                    // this is essentially the "starting page" that's being generated here
                    # TODO: i should probably just make a starting page file (i did)
                    if(!$file){
                        include "view.php";
                    }
                    // file has been selected, has it been cached? is the cached version up to date?
                    else{
                        //grab file hash for cache validation
                        $filehash = md5_file("files/$file");
                        //grab cache history
                        $cachedjson = grabJSON();
                        if(!(array_key_exists($file, $cachedjson) && $cachedjson[$file]["srcmd5"] == md5_file("files/$file"))){
                            //file has not been cached or cache is out of date, create cache
                            $wascached = false;
                            # pandoc ftw
                            $output = [];
                            exec("cat files/".escapeshellcmd($file)." | pandoc -f markdown -t html --wrap=preserve --eol=native", $output);
                            file_put_contents(".files_cached/$file", implode(PHP_EOL, $output));

                            //update cached.json
                            $cachedata = [];
                            $cachedata["srcmd5"] = md5_file("files/$file");
                            $cachedata["cachetime"] = time();
                            $cachedata["size"] = filesize("files/$file");
                            $cachedjson[$file] = $cachedata;
                            putJSON($cachedjson);
                        }
                        //file cached and up to date (now), just print it out
                        echo file_get_contents(".files_cached/$file");
                    }
                ?>
                <!-- # dont judge -->
                <div class="md_footer" align="right" style="visibility: <?=$file != NULL ? "visible" : "hidden"; //don't judge?>">
                    <!-- md5 hash of markdown file -->
                    MD5: <i><?= "$filehash ". ($wascached == true ? " (cached)" : "(not cached)") ?></i> 
                    <!-- link to raw markdown file -->
                    <b><a href="files/<?=$file?>"><?= $file != "" ? "$file raw" : "" ?></a></b>
                </div>
            </div>
        </div>
    </body>
</html>
