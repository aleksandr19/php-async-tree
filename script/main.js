$(function() {
    a_dialog = $("#additem").dialog ({
        autoOpen: false,
        title: "Node Editor",
        modal: true,
        width: 300,
        height: 150,
        open:
            function (e) {
                $("#txt_description").focus();
                // $("#txt_description").select();

                // bind enter to first button
                a_dialog.parent().find('.ui-dialog-buttonpane button:first');

                a_dialog.bind ('keypress', function(e) {
                    if (e.keyCode == 13 ) {
                        a_dialog.parent().find('.ui-dialog-buttonpane button:first').click();
                        e.stopPropagation();
                        return false;
                    }
                });
            },
        create:
            function (event, ui) {},
        close:
            function (e) {},
            buttons: [
                {
                    text: "OK",
                    click: function() {
                        a_dialog.dialog ("close");
                        if (a_dialog.attr ("action") == "add")
                            insertData();
                        else if (a_dialog.attr ("action") == "edit")
                            updateData();
                    }
                },
                {
                    text: "Cancel",
                    click: function() {
                        a_dialog.dialog ("close");                        
                    }
                }
            ]
    });
});

function showDlg() {
    a_dialog.dialog ("open");
}

function clearFields() {
    $("#txt_description").val ("");
    $("#combo_image_name").val ("");
    $("#txt_url").val ("");    
}

function useServerData (key, id) {

    $.ajax ({ // ajax call starts
        url: "server_data.php",  // JQuery loads php file
        cache: false,
        type: "GET",
        dataType: "text",
        data: "key=" + key + "&id=" + id,
        success: function (data) {

            if (data) {
                if (key == "leaf_to_root_path") {
                    var arr = data.split (",");
                    // $.each (arr, function (index, value) {alert (value)});
                    refresh_tree (arr);
                }
                else if (key == "last_record_id") {
                    var last_record_id = data;
                    useServerData ("leaf_to_root_path", last_record_id);
                }
                else {
                    refresh_tree ([last_record_id]);
                }
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

function addItem() {

    // change title    
    a_dialog.dialog ("option", "title", "Add Item");
    
    a_dialog.attr ("action", "add");
    clearFields();
    showDlg();
}

function editItem() {

    // change title
    a_dialog.dialog ("option", "title", "Edit Item");
    
    a_dialog.attr ("action", "edit");
    clearFields();
    
    // set fields

    var selected_id = getSelectedId();
    if (! selected_id) {
        alert ("please select an item");
        return;
    }

    // selected image name
    var j_image = $("li#l" + selected_id).children('img.tree_img').eq(0);
    var complete_file_name = j_image.attr("src");
    var arr = complete_file_name.split ("/");
    var file_name = arr[arr.length - 1];
    
    var s_description = $("a.node-selected").html();
    var s_url = $("a.node-selected").attr("href");

    if (s_url == JS_VOID)
        s_url = "";

    $("#txt_description").val (s_description);
    $("#combo_image_name").val (file_name);
    $("#txt_url").val (s_url);    

    showDlg();
}

function deleteItem() {

    var selected_id = getSelectedId();
    if (! selected_id) {
        alert ("please select an item");
        return;
    }

    if (confirm ("delete '" + $("a.node-selected").html() + "'?"))
        deleteData (selected_id);

}

function getSelectedId() {
    var selected_id = "";
    var selected_link = $("a.node-selected");
    if (selected_link && selected_link.attr("id"))
        selected_id = selected_link.attr("id").substr(1);
    return selected_id;
}

function updateData() {

    var selected_id = getSelectedId();
    
    var str_data = "action=edit&selectedid=" + selected_id + "&description=" + $("#txt_description").val() +
        "&imagename=" + $("#combo_image_name").val() + "&url=" + $("#txt_url").val();
        
    postData (str_data, "edit", selected_id);  // after reloading tree, go to leaf with id selected_id
}

function insertData() {

    // if a node is selected, add new node to it, otherwise, add to root
    var parent_id = getSelectedId();

    var str_data = "action=add&parentid=" + parent_id + "&description=" + $("#txt_description").val() +
        "&imagename=" + $("#combo_image_name").val() + "&url=" + $("#txt_url").val();
        
    postData (str_data, "add", null);
}

function deleteData (selected_id) {

    var str_data = "action=delete&selectedid=" + selected_id;
    postData (str_data, "delete", null);
}
    
function postData (s_data, s_action, sel_id) {
    
    $.ajax ({ // ajax call starts
        url: 'ajax_insert_delete.php',  // JQuery loads php file
        cache: false,
        type: "POST",
        dataType: "text",
        data: s_data,
        success: function (data) {

            // possible errors
            if (data)
                alert (data);

            if (s_action == "edit" && sel_id) {  // after reloading tree, go to leaf with id sel_id

                useServerData ("leaf_to_root_path", sel_id);
            } else if (s_action == "add") {

                useServerData ("last_record_id");
            }
            else
                refresh_tree();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

}
