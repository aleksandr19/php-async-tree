<?php

    include "header.php";
    include "db_class.php";

    $db_class = new dbClass ($connect);

    if (! empty ($_POST ["action"])) {

        if ($_POST ["action"] == "add" && ! empty ($_POST ["description"])) {
            $parent_id   = $_POST ["parentid"];
            $description = $_POST ["description"];
            $image_name  = $_POST ["imagename"];
            $url         = $_POST ["url"];
        }

        try {

          // insert new node
          $db_class -> newNode ($parent_id, $description, $image_name, $url);

        } catch (Exception $e) {
            echo $e -> getMessage();
        }
    }

    include "footer.php";
?>
