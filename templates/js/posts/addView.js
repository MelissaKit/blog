$(window).load(function() {
    var $this = $(this);

    setTimeout(function() {
        $.ajax({
            url: location.origin + '/Posts/AddView/' + location.search,
            type: 'POST',
            success: function() {},
            error: function() {
                console.log("Something went wrong");
            }
        });

    }, 5000);
});