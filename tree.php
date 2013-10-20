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
    
    if (! isset ($root_id))
        die ("root id is not available");

?>

<!-- this JavaScript function will place html code inside of tree container div -->

<script type="text/javascript">

    // define callback function, which will be an argument of reload_tree function
    function callback_function (first_level_nodes_html, arr_root_to_leaf) {

        $("#tree_container").append (first_level_nodes_html); // add html to the container
        
        // expand tree if root-to-leaf path is specified
        if (arr_root_to_leaf) {
        
            function selectLastLeaf() {

                setTimeout (
                    function() {
                        var str_description = "d" + arr_root_to_leaf [arr_root_to_leaf.length - 1];
                        var ele = document.getElementById (str_description);
                        if (ele)
                            clickDescription (ele);
                    }, 100
                );
            }

            var i = 0;

            var interval = setInterval (
                function() {
                    if (i > arr_root_to_leaf.length - 2 || i > 100) {
                        clearInterval (interval);
                        selectLastLeaf();
                        return;
                    }
                    clickPlus (document.getElementById ("p" + arr_root_to_leaf [i]));
                    i++;
                }, 100
            );

        }

        /* put here things that need to be run after tree loads */

    }
    
    function refresh_tree (arr_root_to_leaf) {

        var root_id = "<?php echo $root_id ?>";

        // call reload_tree, which calls callback_function
        // reload_tree is defined in tree.js
        reload_tree (root_id, arr_root_to_leaf, callback_function);    
    }

    $(document).ready (function() {
        refresh_tree (null);
    });

</script>

<?php
    include "footer.php";
?>
