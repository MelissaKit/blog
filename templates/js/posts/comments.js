$(window).load(function() {
    function addCommentsListener() {
        $(".delete-comment a").click(function(e) {
            e.preventDefault();
            var $this = $(this);

            $.ajax({
                url: location.origin + $this.attr('href'),
                type: 'POST',
                success: function(result) {
                    $this.closest('.comment-item').hide();
                }
            });
            return false;

        });
    }

    addCommentsListener();
});