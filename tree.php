<?php

    include "header.php";
    include "db.php";

?>

<link rel="stylesheet" href="css/tree.css" type="text/css" />

<?php

    $db_class = new dbClass ($connect);
    $first_level_data = null;

    try {

        // if db is empty, create first row with parent_id = -1
        $db_class -> insertRoot ($connect);

        // get data for nodes of first level
        $first_level_data = $db_class -> getBaseNodes();

    } catch (Exception $e) {
        echo $e -> getMessage();
    }

?>

<div>

    <img class="tree_img" src="images/computer.png">&nbsp;root
    
    <ul class="node">
    
    <?php
    
        $node_count = sizeof ($first_level_data);
    
        for ($i=0; $i < $node_count; $i++) {
        
            echo "<li>\n";

            // image of plus sing
            $plus_image_name = ($i != $node_count - 1) ? "plus.gif" : "plusbottom.gif";
            
            // image
            $image_name = $first_level_data [$i]["image_name"];
            if (empty ($image_name))
                $image_name = "empty.gif";
            
            // plus sign, image, text
            echo "<img class='tree_img' src='images/" . $plus_image_name . "'>" .
                "<img class='tree_img' src='custom_images/" . $image_name . "'>" .
                $first_level_data [$i]["description"];          

            echo "</li>\n";
        }
    
    ?>
    
    </ul>
      
</div>

<?php
    include "footer.php";
?>
