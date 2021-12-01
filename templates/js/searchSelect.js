$(window).load(function () {
    $("#search").change(function () {
        var toshow = $(this).find('option:selected').prop('value');
        $('#search-result>div').each(function () {
            if($(this).attr('id') == toshow)
            {
                $(this).removeClass('search-hidden');
            }
            else
            {
                $(this).addClass('search-hidden');
            }
        });
    });
});
