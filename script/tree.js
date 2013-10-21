function clickPlus (ele) {

    // ele is a plus sign
    
    var str_node_id = ele.id.substr (1);  // "p2".substr (1) = "2"

    var j_plus_sign = $(ele);                       // jQuery variable of plus sign
    var j_kids_ul   = $("ul#n" + str_node_id);      // jQuery variable of ul containing children nodes
    
    // var j_li        = $("li#l" + str_node_id);  // jQuery variable of li
    // if (j_li.attr("lastnode") == "false")
    
    var j_img       = j_plus_sign.children('img').eq(0);   // jQuery variable of plus sign image
    
    // if node is expanded, collapse it
    if (j_kids_ul.css ("display").toLowerCase() == "block" && j_kids_ul.html() != "") {
        j_kids_ul.css ("display", "none");
        if (j_img.attr ("src") == MINUS)
            j_img.attr ("src", PLUS);
        return;
    }
    
    // else expand node
    j_kids_ul.css ("display", "block");
    
    function dummy_callback() {}

    // populate node from database
    if (j_kids_ul.html() == "")
        setNodeHtml (str_node_id, dummy_callback);
 
    if (j_img.attr ("src") == PLUS)
        j_img.attr ("src", MINUS);
}

function callback_implementation (callback) {
    callback();
}

// does same as clickPlus, but while clickPlus fires by user click, autoExpand
// is called from another function

function autoExpand (ele, callback_function) {

    // ele is a plus sign

    var str_node_id = ele.id.substr (1);                   // "p2".substr (1) = "2"
    var j_plus_sign = $(ele);                              // jQuery variable of plus sign
    var j_kids_ul   = $("ul#n" + str_node_id);             // jQuery variable of ul containing children nodes
    var j_img       = j_plus_sign.children('img').eq(0);   // jQuery variable of plus sign image

    j_img.attr ("src", MINUS);

    // expand node
    if (j_kids_ul.attr("id"))
        j_kids_ul.css ("display", "block");

    function set_node_html_callback() {

        callback_implementation (
            function() {
                callback_function();
            }
        );
    }

    // populate node from database and call the function above
    setNodeHtml (str_node_id, set_node_html_callback);
}

function unselect_all() {

    // make all nodes normal
    $("a.description").each (
        function() {
            $(this).css ("font-weight", "normal");
            $(this).removeClass ("node-selected");
        }
    );
}

function select_description (ele) {
    ele.css ("font-weight", "bold");
    ele.addClass ("node-selected");      
}

// select item without opening link
function clickIcon (ele) {

   // ele is icon
   j_icon = $(ele);  // jQuery variable of icon
   j_li = j_icon.parent ("li").attr("id");
   if (j_li) {
       var str_node_id = j_li.substr (1);  // "l2".substr (1) = "2"
       var j_description = $("#d" + str_node_id);

        unselect_all();
        
        // make description bold and add class node-selected
        select_description (j_description);
   }
}

function clickDescription (ele) {

    // ele is description hyperlink
    
    var str_node_id = ele.id.substr (1);  // "d2".substr (1) = "2"
    var j_description = $(ele);
    
    unselect_all();

    // make description bold and add class node-selected
    select_description (j_description);

    // here you can put your custom code using str_node_id


}

function setNodeHtml (s_node_id, callback_received_data) {

// data
// [
//     {"id":3,"parent_id":1,"level":1,"description":"first","image_name":"","cnt":1},
//     {"id":4,"parent_id":1,"level":1,"description":"second","image_name":"folder.gif","cnt":null}
// ]

    $.ajax ({ // ajax call starts
        url: './ajax_nodes_data.php',  // JQuery loads php file
        cache: false,
        type: "GET",
        dataType: "text",
        data: "nodeid=" + s_node_id,
        success: function (data) {  // Variable data contains the data we get from serverside
            $("#n" + s_node_id).html (data);

            callback_implementation (
                function() {
                    callback_received_data();
                }
            );
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

// callback_function is an argument of asynchronious function reload_tree
// after reload_tree succeeds, it calls callback_function, which
// contains value set by reload_tree

function reload_tree (root_id, arr_root_to_leaf, callback_function) {
                    
    // insert root
    var str_html = "<img class='tree_img' src='images/computer.png' />&nbsp;root\n";
    $("#tree_container").html (str_html);
        
    // add first level nodes

    $.ajax ({ // ajax call starts
        url: 'ajax_nodes_data.php',  // JQuery loads php file
        cache: false,
        type: "GET",
        dataType: "text",
        data: "nodeid=" + root_id,
        success: function (data) { // Variable data contains the data we get from serverside

            var s_html =
                "<ul class='node' style='padding-top: 2px;'>\n" +  // open ul
                data +                                             // tree nodes
                "</ul>\n";                                         // close ul

            callback_implementation (
                function() {
                    callback_function (s_html, arr_root_to_leaf);
                }
            );
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}
