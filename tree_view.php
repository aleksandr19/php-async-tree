<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>

<head>
<meta charset="utf-8" />
<title>Tree</title>

<link rel="stylesheet" href="css/main.css" type="text/css" />

<script src="script/modernizr-latest.js" type="text/javascript"></script>
<script src="script/jquery-1.10.2.js" type="text/javascript"></script>
<script src="script/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>

<?php include "constants.php";  // define JS_VOID and CUSTOM_IMAGES ?>

<script type="text/javascript">

    // create constant for JavaScript

    var JS_VOID = "<?php echo JS_VOID ?>";

</script>

<script src="script/main.js" type="text/javascript"></script>

<?php include "tree.php"; ?>

<?php

    // image files list
    $arr_image_files = scandir (CUSTOM_IMAGES, 1);
    
    // filter out . and ..

    function remove_dots ($var) {
        return ($var !== "." && $var !== "..");
    }

    $arr_image_files = array_filter (
        $arr_image_files, "remove_dots"
    );

?>

</head>
<body>

<div style="margin-bottom: 12px;">
    to select an item, click on its icon
    <br/>
    to open a link, click on the text
</div>

<div style="margin-bottom: 5px;">

    <!-- addItem, editItem, deleteItem are defined in script/main.js -->
    <!-- refresh_tree is defined in tree.php                         -->

    <a href="<?php echo JS_VOID ?>" onClick="addItem();"
    ><img src="images/add.gif" title="new"/></a>    
    &nbsp;
    <a href="<?php echo JS_VOID ?>" onClick="editItem();"
    ><img src="images/edit.gif" title="change"/></a>
    &nbsp;
    <a href="<?php echo JS_VOID ?>" onClick="deleteItem();"
    ><img src="images/delete.gif" title="delete"/></a>
    &nbsp;
    <a href="<?php echo JS_VOID ?>" onClick="refresh_tree();"
    ><img src="images/refresh.png" title="refresh"/></a>
</div>

<div id="tree_container">
</div>

<!-- dialog -->
<div style="display: none;">
  <div id="additem" style="border: solid #00aaaa 1px; background-color: #ccffff;">
    <form>
      <div class="div_table">
        <div class="div_row">
          <div class="div_cell_left">description:</div>
          <div class="div_cell_right"><input id="txt_description" type="text" maxlength="255" /></div>
        </div><div class="div_row">
          <div class="div_cell_left">image file name:</div>

          <!-- list of image files -->
          <select id="combo_image_name">
            <option></option>
            <?php foreach ($arr_image_files as $image_file): ?>
              <option value="<?php echo $image_file ?>">
                <?php echo $image_file ?>
              </option>
            <?php endforeach ?>
          </select>

        </div><div class="div_row">
          <div class="div_cell_left">link:</div>
          <div class="div_cell_right"><input id="txt_url" type="text" maxlength="255" /></div>
        </div>
      </div>
    </form>
  </div>
</div>

</body>
</html>
