$(window).load(function() {
    function addLikeListener() {
        $(".like-link, .unlike-link").off().click(function(e) {
            e.preventDefault();
            var $this = $(this);

            $.ajax({
                url: location.origin + $this.attr('href'),
                type: 'POST',
                success: function(result) {
                    $this.replaceWith(result['newButton']);
                    addLikeListener();
                },
                error: function() {
                    alert("Something went wrong");
                }
            });
            return false;

        });
    }

    addLikeListener();
});