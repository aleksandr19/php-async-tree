<?php

    // provides data for javascript via ajax
    // this php file is loaded from function getServerData in script/main.js

    include "header.php";
    include "db_class.php";

    $db_class = new dbClass ($connect);

    if (isset ($_GET ["key"])) {
    
        switch ($_GET ["key"]) {

            // array of ids of nodes from the given node to the root
            case "leaf_to_root_path":
                if (isset ($_GET ["id"])) {
                    $arr = $db_class -> getLeafToRootPath ($_GET ["id"]);
                    
                    // comma separated ids from the root to the node
                    $arr = array_reverse ($arr);
                    array_shift ($arr);    // remove root id
                    echo implode (",", $arr);                    
                }
                break;
            case "last_record_id":
                echo $db_class -> getLastRecordId();
                break;

            default:

                break;
        }
    }

    include "footer.php";
?>
