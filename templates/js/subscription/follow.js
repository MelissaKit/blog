$(window).load(function() {
    function addFollowListener() {
        $(".follow-link, .unfollow-link").off().click(function(e) {
            e.preventDefault();
            var $this = $(this);
            var isFollow = $(this).hasClass('follow-link');

            $.ajax({
                url: location.origin + $this.attr('href'),
                type: 'POST',
                success: function(result) {
                    if (isFollow) {
                        $this.parent().find('.unfollow-link').show();
                        $this.parent().find('.follow-link').hide();
                    } else {
                        $this.parent().find('.unfollow-link').hide();
                        $this.parent().find('.follow-link').show();
                    }
                }
            });
            return false;

        });
    }

    addFollowListener();
});