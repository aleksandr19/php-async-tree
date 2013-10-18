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