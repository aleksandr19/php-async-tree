php-async-tree
=============

#####PHP tree with asynchronously loading data#####

####Features:####
1. use of AJAX: page doesn't need to be reload when user explores the tree or makes changes to it.

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
