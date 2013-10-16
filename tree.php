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

    // callback_function is an argument of asynchronious function reload_tree
    // after reload_tree succeeds, it calls callback_function, which
    // contains value set by reload_tree

    function callback_implementation (callback) {
        callback();
    }
    
    function reload_tree (callback_function) {
                        
        // insert root
        var str_html = "<img class='tree_img' src='images/computer.png' />&nbsp;root\n";
        $("#tree_container").html (str_html);
            
        // add first level nodes
    
        var s_node_id = "<?php echo $root_id ?>";

        $.ajax ({ // ajax call starts
            url: 'ajax_nodes_data.php',  // JQuery loads php file
            type: "GET",
            dataType: "text",
            data: "nodeid=" + s_node_id,
            success: function (data) { // Variable data contains the data we get from serverside

                if (! jQuery.isEmptyObject (data)) {
                    var s_html =
                        "<ul class='node' style='padding-top: 2px;'>\n" +  // open ul
                        data +                                             // tree nodes
                        "</ul>\n";                                         // close ul
                    
                    callback_implementation (
                        function() {
                            callback_function (s_html);
                        }
                    );
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    }

    // define callback function, which will be an argument of reload_tree function
    function callback_function (first_level_nodes_html) {

        $("#tree_container").append (first_level_nodes_html); // add html to the container

        /* put here things that need to be run after tree loads */

    }

    $(document).ready (function() {

        // call reload_tree, which calls callback_function
        reload_tree (callback_function);
    });

</script>

<?php
    include "footer.php";
?>
