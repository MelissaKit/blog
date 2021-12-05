$(window).load(function() {
    var $this = $(this);

    setTimeout(function() {
        $.ajax({
            url: location.origin + '/Posts/AddView/' + location.search,
            type: 'POST',
            success: function() {},
            error: function() {
                alert("Something went wrong");
            }
        });

    }, 10000);
});