<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>

<head>
<meta charset="utf-8" />
<title>Tree</title>

<script src="script/modernizr-latest.js" type="text/javascript"></script>
<script src="script/jquery-1.10.2.js" type="text/javascript"></script>

<?php include "tree.php"; ?>

</head>
<body>

<div>
    <a href="#"><img src="images/add.gif" title="new"/></a>
    &nbsp;
    <a href="#"><img src="images/edit.gif" title="change"/></a>
    &nbsp;
    <a href="#"><img src="images/delete.gif" title="delete"/></a>
    &nbsp;
    <a href="javascript: void(null);" onClick="javascript: reload_tree (callback_function);"
    ><img src="images/refresh.png" title="refresh"/></a>
</div>

<br />

<div id="tree_container">
</div>

</body>
</html>
