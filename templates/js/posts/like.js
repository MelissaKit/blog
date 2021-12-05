$(window).load(function() {
    function addLikeListener() {
        $(".like-link, .unlike-link").off().click(function(e) {
            e.preventDefault();
            var $this = $(this);
            var isLike = $(this).hasClass('like-link');

            $.ajax({
                url: location.origin + $this.attr('href'),
                type: 'POST',
                success: function(result) {
                    if (isLike) {
                        $this.parent().find('.unlike-link').show();
                        $this.parent().find('.like-link').hide();
                    } else {
                        $this.parent().find('.unlike-link').hide();
                        $this.parent().find('.like-link').show();
                    }
                }
            });
            return false;

        });
    }

    addLikeListener();
});