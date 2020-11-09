<?php
    //grab file GET
    $file = array_key_exists("file", $_GET) ? $_GET["file"] : NULL;

    function grabJSON($filepath){
        return json_decode(file_get_contents($filepath), true);
    }
    function putJSON($filepath, $assoc){
        file_put_contents($filepath , json_encode($assoc, JSON_PRETTY_PRINT));
    }
?>

<html>
    <head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" type="text/css" href="../style.css"\>
        <link rel="stylesheet" type="text/css" href="additional.css"\>
    </head>
    <body>
        <div align="center" class="md_divbody">
            <div class="md_divcontent">
                <?php
                    // if no file given, show list of files in file directory
                    // this is essentially the "starting page" that's being generated here
                    // TODO: i should probably just make a starting page file
                    if(!$file){
                        echo md5_file("files/$file");
                        //generate table of markdown files that can be accessed
                        echo "<table>";
                        echo "<tr><td>Files:</td></tr>";

                        foreach(glob("files/*.md") as $filename){
                            $filename = basename($filename);

                            echo "<tr><td><a href=\"?file=$filename\">$filename</a></td></tr>";
                        }

                        echo "</table>";
                    }
                    // file has been selected, has it been cached? is the cached version up to date?
                    else{
                        $cachedjson = grabJSON(".files_cached/cached.json");
                        if(!(array_key_exists($file, $cachedjson) && $cachedjson[$file]["srcmd5"] == md5_file("files/$file"))){
                            //file has not been cached or cache is out of date, create cache
                            //pandoc ftw
                            $output = [];
                            exec("cat files/".escapeshellcmd($file)." | pandoc -f markdown -t html --wrap=preserve --eol=native", $output);
                            file_put_contents(".files_cached/$file", implode(PHP_EOL, $output));

                            //update cached.json
                            $cachedata = [];
                            $cachedata["srcmd5"] = md5_file("files/$file");
                            $cachedata["cachetime"] = time();
                            $cachedjson[$file] = $cachedata;
                            putJSON(".files_cached/cached.json", $cachedjson);
                        }
                        //file cached and up to date (now), just print it out
                        echo file_get_contents(".files_cached/$file");
                    }
                ?>
                <div class="md_raw"><b><a href="files/<?=$file?>"><?= $file != "" ? "$file raw" : "" ?></a></b></div>
            </div>
        </div>
    </body>
</html>
