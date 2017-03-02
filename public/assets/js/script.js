
(function () {

    /** Delete Button Modal **/
    $('#delete-actor').on('click', function(e) {

        e.preventDefault();

        $('#myModal').modal('show');

        $('#confirm-delete').on('click', function(e) {
            $("#delete-actor").unbind('click').click();
        });

    });


})();
