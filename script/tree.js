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
        j_img.attr ("src", PLUS);
        return;
    }
    
    // else expand node
    j_kids_ul.css ("display", "block");

    // populate node from database
    if (j_kids_ul.html() == "")
        setNodeHtml (str_node_id);
 
    j_img.attr ("src", MINUS);
}

function clickDescription (ele) {

    // ele is description hyperlink
    
    var str_node_id = ele.id.substr (1);  // "p2".substr (1) = "2"
    var j_description = $(ele);
    
    // make all nodes normal
    $("a.description").each (
        function() {
            $(this).css ("font-weight", "normal");
            $(this).removeClass ("node-selected");
        }
    );

    // make clicked node bold
    j_description.css ("font-weight", "bold");
    j_description.addClass ("node-selected");
    
    // here you can put your custom code using str_node_id


}

function setNodeHtml (s_node_id) {

// data
// [
//     {"id":3,"parent_id":1,"level":1,"description":"first","image_name":"","cnt":1},
//     {"id":4,"parent_id":1,"level":1,"description":"second","image_name":"folder.gif","cnt":null}
// ]

    $.ajax ({ // ajax call starts
        url: './ajax_nodes_data.php',  // JQuery loads php file
        type: "GET",
        dataType: "text",
        data: "nodeid=" + s_node_id,
        success: function (data) {  // Variable data contains the data we get from serverside
            $("#n" + s_node_id).html (data);
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

function callback_implementation (callback) {
    callback();
}

function reload_tree (root_id, callback_function) {
                    
    // insert root
    var str_html = "<img class='tree_img' src='images/computer.png' />&nbsp;root\n";
    $("#tree_container").html (str_html);
        
    // add first level nodes

    $.ajax ({ // ajax call starts
        url: 'ajax_nodes_data.php',  // JQuery loads php file
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
                    callback_function (s_html);
                }
            );
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}
