var selected_user_id = 0;

var options = {
    url: function (phrase) {
        return "/get_users_by_phrase/" + phrase;
    },

    getValue: "full_name",
    requestDelay: 300,
    list: {
        onChooseEvent: function () {
            selected_user_id = $("#user-provider-remote").getSelectedItemData().id;
            console.log("user id ->" + selected_user_id);

        },
        showAnimation: {
            type: "fade",
            time: 300,
            callback: function () {
            }
        },

        hideAnimation: {
            type: "slide", //normal|slide|fade
            time: 300,
            callback: function () {
            }
        }
    }
};

$("#user-provider-remote").easyAutocomplete(options);


function viewUserProfile() {
    var value = $("#user-provider-remote").getSelectedItemData().id;

    //console.log("view data->" + $("#user-provider-remote").getItemData());
    //console.log("view user id ->" + selected_user_id);
    window.location.href = window.location.origin + "/admin_panel/view_user_profile/" + selected_user_id;
}
