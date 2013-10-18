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
                $("#txt_description").select();

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
                        insertData() ;                        
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

function addItem() {

    // change title
    a_dialog.dialog ("option", "title", "Add Item");

    showDlg();
}

function insertData() {

    // if a node is selected, add new node to it, otherwise, add to root
    var parent_id = "";
    var selected_link = $("a.node-selected");
    if (selected_link && selected_link.attr("id"))
        parent_id = selected_link.attr("id").substr(1);

    var str_data = "action=add&parentid=" + parent_id + "&description=" + $("#txt_description").val() +
        "&imagename=" + $("#txt_image_name").val() + "&url=" + $("#txt_url").val();
    
    $.ajax ({ // ajax call starts
        url: 'ajax_insert_delete.php',  // JQuery loads php file
        type: "POST",
        dataType: "text",
        data: str_data,
        success: function (data) {
        
            // possible errors
            if (data)
                alert (data);

            refresh_tree();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });


}
