function submitForm_delete_user(form,username) {
    swal({
        title: "Are you sure? (Delete User)",
        text: username,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then(function (isOkay) {
        if (isOkay) {
            form.submit();
        }
    });
    return false;
}


function submitForm_logout(form,username) {
swal({
    title: "Are you sure? (Logout)",
    text: username,
    icon: "warning",
    buttons: true,
    dangerMode: true,
})
.then(function (isOkay) {
    if (isOkay) {
        form.submit();
    }
});
return false;
}