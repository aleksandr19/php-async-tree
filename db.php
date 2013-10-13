<?php

class dbClass {

    private $conn = null;

    public function __construct ($cn) {
        $this -> conn = $cn;
    }

    public function insertRoot()  {

        $query = "insert into tree (parent_id, level, description) " .
            " select -1, 0, 'root' from tree having count(`id`) = 0";

        $stmt = mysqli_prepare ($this -> conn, $query);

        if ($stmt === false)
            throw new Exception (htmlspecialchars (mysqli_error ($this -> conn)));

        /* execute query */
        $success = mysqli_stmt_execute ($stmt);
    
        /* close statement */
        mysqli_stmt_close ($stmt);
    
        if (! $success)
            throw new Exception (htmlspecialchars (mysqli_error ($this -> conn)));
    }
    
    public function newNode ($parent_id, $description, $image_name) {

        if (empty ($parent_id))
            throw new Exception ("parent id is not provided");
        
        $str_sql = "select `level` from tree where `id` = ?";
        $level = $this -> getSingleValueWithParam ($str_sql, $parent_id);
        
        echo "level = " . $level . "<br>\n";

        $query = "insert into tree (parent_id, `level`, `description`, image_name) " .
            " values (?, ?, ?, ?)";

        $stmt = mysqli_prepare ($this -> conn, $query);

        if ($stmt === false)
            throw new Exception (htmlspecialchars (mysqli_error ($this -> conn)));
        
        $level++;
        
        /* bind parameters for markers */
        mysqli_stmt_bind_param ( $stmt, "iiss",
            $parent_id, $level, $description, $image_name);

        /* execute query */
        $success = mysqli_stmt_execute ($stmt);
    
        /* close statement */
        mysqli_stmt_close ($stmt);
    
        if (! $success)
            throw new Exception (htmlspecialchars (mysqli_error ($this -> conn)));
    }
    
    // returns multidimensional array of the node of the first level
    public function getBaseNodes() {
    
        $str_sql = "select * from tree where parent_id in " .
            " (select `id` from tree where parent_id = -1)";

        $result = mysqli_query ($this -> conn, $str_sql);

        if ($result === false)
            throw new Exception (htmlspecialchars (mysqli_error ($this -> conn)));
            
        $arr = array();

        while ($row = mysqli_fetch_array ($result, MYSQLI_ASSOC))
        {
            array_push ($arr,
                array (
                    "id"          => $row["id"],
                    "parent_id"   => $row["parent_id"],
                    "level"       => $row["level"],
                    "description" => $row["description"],
                    "image_name"   => $row["image_name"]
                )
            );
        }

        /* free result set */
        mysqli_free_result($result);
        
        return $arr;    
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

function sample ($conn) {

    $query = "insert into tree (`id`, parent_id) values (?, ?)";
    $stmt = mysqli_prepare ($conn, $query) or die (mysqli_error ($conn));

    /* bind parameters for markers */
    mysqli_stmt_bind_param ( $stmt, "ii", $max_id, $description, $deposit);

    /* execute query */
    mysqli_stmt_execute ($stmt);

    /* close statement */
    mysqli_stmt_close( $stmt);
}


?>
