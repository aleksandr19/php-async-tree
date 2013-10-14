<?php

class treeClass {

    // returns html, each line contains plus sing, image, and text
    public function htmlFromArray ($level_data) {

        $node_count = sizeof ($level_data);

        for ($i=0; $i < $node_count; $i++) {

            echo "<li>\n";

            // image of plus sing
            if ($i != $node_count - 1) {
                if ($level_data [$i]["cnt"] > 0)
                    $plus_image_name = "plus.gif";
                else
                    $plus_image_name = "minus.gif";
            }
            else {
                if ($level_data [$i]["cnt"] > 0)
                    $plus_image_name = "plusbottom.gif";
                else
                    $plus_image_name = "minusbottom.gif";
            }

            // image
            $image_name = $level_data [$i]["image_name"];
            if (empty ($image_name))
                $image_name = "empty.gif";
                
            $id = $level_data [$i]["id"];

            // plus sign, image, text
            echo "<a href='javascript: void(null)' " .
                "onClick='javascript: setNodeHtml (" . $id . ");' >" .
                "<img class='tree_img' src='images/" . $plus_image_name . "'>" .
                "</a>" .
                "<img class='tree_img' src='custom_images/" . $image_name . "'>" .
                $level_data [$i]["description"] . "\n";
                
            echo "<ul class='node' id='n" . $id . "'></ul>\n";

            echo "</li>\n";
        }
    }

}

?>
