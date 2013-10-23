php-async-tree
=============

#####PHP tree with asynchronously loading data#####

####Features:####
1. use of AJAX: page is not reloaded when user explores the tree or makes changes to it.

2. On start up, only the first generation of nodes (root level) is loaded.  When user expands a node, data that creates children nodes is asynchronously pulled from the server.

3. Different nodes can have different icons.

4. Data comes from MySQL database.

5. Interface includes buttons that allow user to create / modify / delete nodes

####Installation:####

#####System Requirements#####

You will need PHP and MySQL installed on your system or on a hosting environment.  This application has been tested with PHP 5.4.8 and MySQL 5.0.10.

Also, your browser should support jQuery, so it should be relatively new.  This application works on IE 8.

* Download the source code:

download zip file: [http://aziga.x10.mx/image\_tree\_view/php-async-tree.zip](http://aziga.x10.mx/image_tree_view/php-async-tree.zip)

or if you have Git

    git clone https://github.com/aleksandr19/php-async-tree    

create a new folder (for example, "php\_async\_tree") in "C:\inetpub\wwwroot" (or where you usually put php files).  Copy the source code into the folder you've just created.

* Create database table:

run this script in MySQL

    create table tree
        (id integer not null auto_increment,
        parent_id integer not null,
        `level` integer,
        `description` varchar(50),
        image_name varchar(255),
        `url` varchar(255),
        constraint tree_pk primary key (id)
    )

Notice that the table name doesn't necessarily have to be "tree".  You can name your table differently, but in that case you need to modify file "db_class.php":

replace

    define ("TABLE_NAME", "tree");
with

    define ("TABLE_NAME", "<your table name>");

* Configure connection:

edit header.php file and replace words "host", "user", "password", "database" with actual values:

    mysqli_connect("host","user","password","database")

That's all.  Start your web server, and point your browser to

    http://<host name>/<virtual directory>/index.php

You should see your tree.

####Usage:####

To select a node, click on it's icon.  You also can click on the hyperlink, but that would open the link in the browser (if url has been assigned to that node).

Once a node is selected, you can add a child to it.  To do that, click on Add button (green plus icon at the top).  A dialog will appear with the following:

* description: node's text
* image file name: drop down list of images stored in "custom_images" folder.  You can put your own image files there (size 16x16 is recommended).
* link: web site address (such as http://www.microsoft.com) of the node's hyperlink

To add a node at the root level, click Refresh button (so none of the nodes is selected), and then click Add button.

To edit a node, select it and press Change button (looks like a pencil).

To delete, press Delete button (red x).

Refresh button (looks like a curved arrow) reloads the tree.

####Contact me:####
Please email me at aleksandr19@yahoo.com if you have any questions or comments
