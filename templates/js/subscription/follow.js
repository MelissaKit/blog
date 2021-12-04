$(window).load(function () {
    function addFollowListener() {
        $(".follow-link, .unfollow-link").off().click(function (e) {
            e.preventDefault();
            var $this = $(this);

            $.ajax({
                url: location.origin + $this.attr('href'),
                type: 'GET',
                success: function (result) {
                    $this.replaceWith(result['newButton']);
                    addFollowListener();
                },
                error: function () {
                    alert("Something went wrong");
                }
            });
            return false;

        });
    }

    addFollowListener();
});