function editPriority(tableName, column, id, action) {
    // Validate action parameter
    if (action !== 'plus' && action !== 'minus') {
        console.error('Invalid action parameter. Use "plus" or "minus".');
        return;
    }
    // Make AJAX request to edit priority
    $.ajax({
        type: 'POST',
        url: 'action_update_priority', // Replace with your server-side script URL
        data: {
            tableName: tableName,
            column: column,
            id: id,
            action: action
        },
        success: function (response) {
            if (response.trim() === 'success') {
                window.location.reload();
            } else {
                swal('It is the Top priority!');
            }
        },
        error: function () {
            console.error('An error occurred while editing priority. Please try again later.');
        }
    });
}

function editVisibility(tableName, column, id) {
    $.ajax({
        type: 'POST',
        url: 'action_update_visibility', // Replace with your server-side script URL
        data: {
            tableName: tableName,
            column: column,
            id: id
        },
        success: function (response) {
            if (response.trim() === 'success') {
                window.location.reload();

            } else {
                swal('Fail', response);
            }
        },
        error: function () {
            console.error('An error occurred while editing priority. Please try again later.');
        }
    });
}
