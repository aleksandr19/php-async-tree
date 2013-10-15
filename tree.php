<?php

    include "header.php";
    include "db_class.php";
    include "tree_class.php";

?>

<link rel="stylesheet" href="css/tree.css" type="text/css" />

<script src="script/tree.js" type="text/javascript"></script>

<?php

    $db_class = new dbClass ($connect);
    $first_level_data = null;

    try {

        // if db is empty, create first row with parent_id = -1
        $db_class -> insertRoot ($connect);

        // get data for nodes of first level
        $root_id = $db_class -> getRootId();
        $first_level_data = $db_class -> getNodes ($root_id);

    } catch (Exception $e) {
        echo $e -> getMessage();
    }

?>

<div>

    <img class="tree_img" src="images/computer.png">&nbsp;root
    
    <ul class="node">
    
    <?php

        $tree_class = new treeClass();
        $tree_class -> htmlFromArray ($first_level_data);
    
    ?>
    
    </ul>
      
</div>

<?php
    include "footer.php";
?>
