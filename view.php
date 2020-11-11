
<div align="center" style="position: relative">
    <h2 class="title">mdwv</h2>
    <b class="splash" style="display: <?= $splash ? "block" : "none"?>"><?php $msgs = file("splashes.txt"); echo $msgs[rand(0, count($msgs) - 1)]; ?> </b>
    <h5 class="title" style="margin-top: -5px;"><b>m</b>ark<b>d</b>own<b>w</b>eb<b>v</b>iewer</h5>
</div>
<br>
<table class="viewtable">
    <tr>
        <td>File</td>
        <td>Last cache</td>
    </tr>
    <?php
        $cachedjson = grabJSON();

        foreach(glob("files/*.md") as $filename){
            $filename = basename($filename);

            # there has to be a better way than this, right?
            # i should look up if the templating has a solution for this
            echo "    <tr>";
            echo "        <td>";
            echo "            <a href=\"?file=$filename\">$filename</a>";
            echo "        </td>";
            echo "        <td>";
            echo "            <p>".date('d.m.Y \a\t H:i:s', $cachedjson[$filename]["cachetime"])."</p>";
            echo "        </td>";
            echo "    </tr>";
        }
    ?>

</table>