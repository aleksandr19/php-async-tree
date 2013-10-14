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
        success: function (data) { // Variable data contains the data we get from serverside

            if (! jQuery.isEmptyObject (data)) {
                $("#n" + s_node_id).html (data);
            }
            else
                $("#n" + s_node_id).html ("");
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
      }
    });
}

function arrayToHtml (data) {
}
