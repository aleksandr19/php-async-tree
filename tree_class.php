<?php

define ("EMPTYIMG", "images/empty.gif");
define ("PLUS",     "images/plus.gif");
define ("MINUS",    "images/minus.gif");

?>

<script type="text/javascript">

    // create constants for JavaScript

    var EMPTYIMG = "<?php echo EMPTYIMG ?>";
    var PLUS     = "<?php echo PLUS ?>";
    var MINUS    = "<?php echo MINUS ?>";

</script>

<?php

class treeClass {

    // returns html, each line contains plus sing, image, and text
    public function htmlFromArray ($level_data) {
    
        $str_html = "";

        $node_count = sizeof ($level_data);

        for ($i=0; $i < $node_count; $i++) {
        
            $is_last_node = ($i == $node_count - 1);
            $id = $level_data [$i]["id"];

            $str_html .= "<li id='l" . $id . "' lastnode='" . (($is_last_node) ? "true" : "false") .
                "' >\n";

            // image of plus sing
            if ($level_data [$i]["cnt"] > 0)
                $plus_image_name = PLUS;
            else
                $plus_image_name = EMPTYIMG;

            // image
            $image_name = $level_data [$i]["image_name"];
            if (empty ($image_name))
                $image_name = "empty.gif";
                
            $str_url = $level_data [$i]["url"];
            if (empty ($str_url))
                $str_url = "javascript: void (null);";

            // plus sign, image, text
            $str_html .=  "<a class='plus' id='p" . $id . "' " .
                "href='javascript: void(null)' " .
            
                // clickPlus and  clickDescription functions are defined in script/tree.js
                "onClick='javascript: clickPlus (this);' >" .
                "<img class='tree_img' src='" . $plus_image_name . "'/>" .
                "</a>" .
                "<img class='tree_img' src='custom_images/" . $image_name . "'/>" .
                "<a href='" . $str_url . "' onClick='javascript: clickDescription (this);' " .
                "class='description' id='d" . $id . "' >" .
                $level_data [$i]["description"] .
                "</a>\n";
                
            $str_html .=  "<ul class='node' style='display: none;' id='n" . $id . "'></ul>\n";

            $str_html .=  "</li>\n";
        }
        return $str_html;
    }

}

?>
