
<script src="script/jquery-1.10.2.js" type="text/javascript"></script>
<script src="script/tree.js" type="text/javascript"></script>

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
          echo $tree_class -> htmlFromArray ($level_data);

        } catch (Exception $e) {
            echo $e -> getMessage();
        }
    }

    include "footer.php";
?>
