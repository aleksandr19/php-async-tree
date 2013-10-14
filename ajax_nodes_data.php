<?php

    include "header.php";
    include "db_class.php";
    include "tree_class.php";

    $db_class = new dbClass ($connect);
    
    if (! empty ($_GET ["nodeid"])) {

        try {

          // get data for nodes
          $level_data = $db_class -> getNodes ($_GET ["nodeid"]);

          $tree_class = new treeClass();
          $tree_class -> htmlFromArray ($level_data);

        } catch (Exception $e) {
            echo $e -> getMessage();
        }
    }

    include "footer.php";
?>
