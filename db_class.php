<?php

/*
 * a class to retrieve information from database or make changes to it
 *
 *  this work is licensed under the The MIT License (MIT)
 *  name      PHP Async Tree
 *  web site  https://github.com/aleksandr19/php-async-tree
 *  author    aleksandr19 <aleksandr19@yahoo.com>
 *  copyright (c) 2013 aleksandr19
 */

define ("TABLE_NAME", "tree");

class dbClass {

    private $conn = null;

    public function __construct ($cn) {
        $this -> conn = $cn;
    }

    public function insertRoot()  {

        $query = "insert into " . TABLE_NAME . " (parent_id, level, description) " .
            " select -1, 0, 'root' from " . TABLE_NAME . " having count(`id`) = 0";

        $stmt = mysqli_prepare ($this -> conn, $query);

        if ($stmt === false)
            throw new Exception (htmlspecialchars (mysqli_error ($this -> conn)));

        /* execute query */
        $success = mysqli_stmt_execute ($stmt);

        $str_error = "";
        if (! $success)
            $str_error = htmlspecialchars (mysqli_error ($this -> conn));

        /* close statement */
        mysqli_stmt_close ($stmt);

        if (! $success)
            throw new Exception ($str_error);
    }
    
    public function changeNode ($selected_id, $description, $image_name, $url) {

        if (! isset ($selected_id))
            throw new Exception ("id of node being update is missing");

        $query = "update " . TABLE_NAME . " set `description` = ?, image_name = ?, `url` = ? " .
            " where `id` = ?";

        $stmt = mysqli_prepare ($this -> conn, $query);

        if ($stmt === false)
            throw new Exception (htmlspecialchars (mysqli_error ($this -> conn)));

        /* bind parameters for markers */
        mysqli_stmt_bind_param ($stmt, "sssi",
            $description, $image_name, $url, $selected_id);

        /* execute query */
        $success = mysqli_stmt_execute ($stmt);

        $str_error = "";
        if (! $success)
            $str_error = htmlspecialchars (mysqli_error ($this -> conn));

        /* close statement */
        mysqli_stmt_close ($stmt);

        if (! $success)
            throw new Exception ($str_error);

    }

    public function newNode ($parent_id, $description, $image_name, $url) {

        if (! isset ($parent_id) || $parent_id == "")
            $parent_id = $this -> getRootId();
        
        $str_sql = "select `level` from " . TABLE_NAME . " where `id` = ?";
        $level = $this -> getSingleValueWithParam ($str_sql, $parent_id);

        $query = "insert into " . TABLE_NAME . " (parent_id, `level`, `description`, image_name, `url`) " .
            " values (?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare ($this -> conn, $query);

        if ($stmt === false)
            throw new Exception (htmlspecialchars (mysqli_error ($this -> conn)));
        
        $level++;
        
        /* bind parameters for markers */
        mysqli_stmt_bind_param ($stmt, "iisss",
            $parent_id, $level, $description, $image_name, $url);

        /* execute query */
        $success = mysqli_stmt_execute ($stmt);

        $str_error = "";
        if (! $success)
            $str_error = htmlspecialchars (mysqli_error ($this -> conn));

        /* close statement */
        mysqli_stmt_close ($stmt);
    
        if (! $success)
            throw new Exception ($str_error);
    }

    public function getLastRecordId() {
    
        $str_sql = "select max(`id`) from " . TABLE_NAME;
        return $this -> getSingleValue ($str_sql);
    }

    public function getChildCount ($selected_id) {

        $str_sql = "select count(`id`) from " . TABLE_NAME .
            " where parent_id = ?";

        return $this -> getSingleValueWithParam ($str_sql, $selected_id);
    }

    private function getParentId ($id) {
    
        $str_sql = "select parent_id from " . TABLE_NAME . " where `id` = ?";
        return $this -> getSingleValueWithParam ($str_sql, $id);    
    }

    public function getLeafToRootPath ($id) {

        $arr = array();

        // $id is passed by value, so we can modify it without affecting its value outside this function

        // limit by 100 iterations to avoid infinite loop
        for ($i=0; $i < 100; $i++) {
            if (! isset ($id) || $id == -1)
                break;

            $arr[$i] = $id;
            $id = $this -> getParentId ($id);
        }
        return $arr;
    }

    public function deleteNode ($selected_id) {

        if (! isset ($selected_id))
            throw new Exception ("id of node being delete is missing");

        $query = "delete from " . TABLE_NAME . " where `id` = ?";

        $stmt = mysqli_prepare ($this -> conn, $query);

        if ($stmt === false)
            throw new Exception (htmlspecialchars (mysqli_error ($this -> conn)));

        /* bind parameters for markers */
        mysqli_stmt_bind_param ($stmt, "i", $selected_id);

        /* execute query */
        $success = mysqli_stmt_execute ($stmt);
        
        $str_error = "";
        if (! $success)
            $str_error = htmlspecialchars (mysqli_error ($this -> conn));

        /* close statement */
        mysqli_stmt_close ($stmt);

        if (! $success)
            throw new Exception ($str_error);

    }
    
    // returns multidimensional array of the node of the first level
    public function getNodes ($parent_node_id) {
    
        // nodes data and information wheither they have children
        $str_sql = "select t.`id`, t.parent_id, t.`level`, " .
            "t.`description`, t.image_name, t.`url`, agg.cnt " .
            "from " . TABLE_NAME . " t left outer join " .
            "(select count(parent_id) as cnt, parent_id from " . TABLE_NAME .
            " group by parent_id) as agg " .
            "on t.`id` = agg.parent_id " .
            "where t.parent_id = ?";

        $stmt = mysqli_prepare ($this -> conn, $str_sql);
        mysqli_stmt_bind_param ($stmt, "i", $parent_node_id);

        /* execute query */
        mysqli_stmt_execute($stmt);

        /* bind result variables */
        
        // $result = mysqli_stmt_get_result ($stmt);

        // $result = mysqli_query ($this -> conn, $str_sql);
        
        $result = mysqli_stmt_bind_result ($stmt, $id, $parent_id, $level, $description, $image_name, $url, $cnt);

        if ($result === false)
            throw new Exception (htmlspecialchars (mysqli_error ($this -> conn)));
            
        $arr = array();
            
        while (mysqli_stmt_fetch ($stmt)) {
            array_push ($arr,
                array (
                    "id"          => $id,
                    "parent_id"   => $parent_id,
                    "level"       => $level,
                    "description" => $description,
                    "image_name"  => $image_name,
                    "url"         => $url,
                    "cnt"         => $cnt
                )
            );
        }

        // while ($row = mysqli_fetch_array ($result, MYSQLI_ASSOC))
        // {

            /*
            printf ("id=%d parent_id=%d level=%d desc=%s img_name=%s cnt=%d\n<br />",
                $row["id"],
                $row["parent_id"],
                $row["level"],
                $row["description"],
                $row["image_name"],
                $row["cnt"]);
            */
        
            // array_push ($arr,
            //     array (
            //         "id"          => $row["id"],
            //         "parent_id"   => $row["parent_id"],
            //         "level"       => $row["level"],
            //         "description" => $row["description"],
            //         "image_name"  => $row["image_name"],
            //         "url"         => $row["url"],
            //         "cnt"         => $row["cnt"]
            //     )
            // );
        // }
        
        /* close statement */
        mysqli_stmt_close ($stmt);

        /* free result set */
        // mysqli_free_result ($result);
        
        return $arr;    
    }
    
    public function getRootId() {
        return $this -> getSingleValue ("select `id` from " . TABLE_NAME . " where parent_id = -1");
    }

    private function getSingleValue ($str_sql) {

        $result = mysqli_query ($this -> conn, $str_sql);
        
        if ($result === false)
            throw new Exception (htmlspecialchars (mysqli_error ($this -> conn)));

        /* numeric array */
        $row = mysqli_fetch_array ($result, MYSQLI_NUM);

        return $row[0];
    }

    private function getSingleValueWithParam ($str_sql, $param) {

        $stmt = mysqli_stmt_init ($this -> conn);
        $stmt = mysqli_prepare ($this -> conn, $str_sql);
        mysqli_stmt_bind_param ($stmt, "i", $param);

        if (! mysqli_stmt_execute ($stmt))
            throw new Exception (htmlspecialchars (mysqli_error ($this -> conn)));
        else {
            mysqli_stmt_bind_result ($stmt, $result);
            mysqli_stmt_fetch ($stmt);
        }

        mysqli_stmt_close ($stmt);
        return $result;
    }
}

?>
