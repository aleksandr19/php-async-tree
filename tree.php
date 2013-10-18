<?php

    include "header.php";
    include "db_class.php";

?>

<link rel="stylesheet" href="css/tree.css" type="text/css" />

<script src="script/tree.js" type="text/javascript"></script>

<?php

    $db_class = new dbClass ($connect);
    $root_id = null;

    try {

        // if db is empty, create first row with parent_id = -1
        $db_class -> insertRoot ($connect);

        // get database id of root node
        $root_id = $db_class -> getRootId();

    } catch (Exception $e) {
        echo $e -> getMessage();
    }
    
    if (empty ($root_id))
        die ("root id is not available");

?>

<!-- this JavaScript function will place html code inside of tree container div -->

<script type="text/javascript">

    // define callback function, which will be an argument of reload_tree function
    function callback_function (first_level_nodes_html) {

        $("#tree_container").append (first_level_nodes_html); // add html to the container

        /* put here things that need to be run after tree loads */

    }
    
    function refresh_tree() {

        var root_id = "<?php echo $root_id ?>";

        // call reload_tree, which calls callback_function
        // reload_tree is defined in tree.js
        reload_tree (root_id, callback_function);    
    }

    $(document).ready (function() {
        refresh_tree();
    });

</script>

<?php
    include "footer.php";
?>
