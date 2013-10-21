<?php

    include "header.php";
    include "db_class.php";

    $db_class = new dbClass ($connect);

    if (! empty ($_POST ["action"])) {

        if (($_POST ["action"] == "add" || $_POST ["action"] == "edit") && (! empty ($_POST ["description"]))) {
            $description = $_POST ["description"];
            $image_name  = $_POST ["imagename"];
            $url         = $_POST ["url"];

            try {

                if ($_POST ["action"] == "add") {
                    $parent_id  = $_POST ["parentid"];

                    // insert new node
                    $db_class -> newNode ($parent_id, $description, $image_name, $url);
                }
                else if ($_POST ["action"] == "edit") {
                    $selected_id = $_POST ["selectedid"];

                    // change node
                    $db_class -> changeNode ($selected_id, $description, $image_name, $url);
                }

            } catch (Exception $e) {
                echo $e -> getMessage();
            }
        }
        else if ($_POST ["action"] == "delete") {

            $selected_id = $_POST ["selectedid"];
            
            $child_count = $db_class -> getChildCount ($selected_id);
            if ($child_count > 0)
                echo "this item is not empty";
            else

            // delete node
            $db_class -> deleteNode ($selected_id);
        }
    }

    include "footer.php";
?>
