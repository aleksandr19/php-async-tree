<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>

<head>
<meta charset="utf-8" />
<title>Tree</title>

<link rel="stylesheet" href="css/main.css" type="text/css" />

<script src="script/modernizr-latest.js" type="text/javascript"></script>
<script src="script/jquery-1.10.2.js" type="text/javascript"></script>
<script src="script/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>

<script src="script/main.js" type="text/javascript"></script>

<?php include "tree.php"; ?>

</head>
<body>

<div>
    <a href="javascript: void(null);" onClick="addItem();"
    ><img src="images/add.gif" title="new"/></a>    
    &nbsp;
    <a href="#"><img src="images/edit.gif" title="change"/></a>
    &nbsp;
    <a href="#"><img src="images/delete.gif" title="delete"/></a>
    &nbsp;
    <a href="javascript: void(null);" onClick="refresh_tree();"
    ><img src="images/refresh.png" title="refresh"/></a>
</div>

<br />

<div id="tree_container">
</div>

<!-- dialog -->
<div style="display: block;">
  <div id="additem" style="border: solid #00aaaa 1px; background-color: #ccffff;">
    <form>
      <div class="div_table">
        <div class="div_row">
          <div class="div_cell_left">description:</div>
          <div class="div_cell_right"><input id="txt_description" type="text" /></div>
        </div><div class="div_row">
          <div class="div_cell_left">image file name:</div>
          <div class="div_cell_right"><input id="txt_image_name" type="text" /></div>
        </div><div class="div_row">
          <div class="div_cell_left">link:</div>
          <div class="div_cell_right"><input id="txt_url" type="text" /></div>
        </div>
      </div>
    </form>
</div>

</body>
</html>
