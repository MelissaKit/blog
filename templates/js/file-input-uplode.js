$("#canAvatar").click(function () {
    $('#canAvatarLabel').removeClass('visible-img');
    $('#imagePreview').removeClass('visible-img');
    $('input[name="posterPath"]').val('')
    $('input[name="posterPath"]').wrap('<form>').closest('form').get(0).reset();
    $('input[name="posterPath"]').unwrap();
});

$('label[for="posterPath"]').click(function() {
    checkFileAndLoadPreview = function () {
        const fileInput = $('input[name="posterPath"]')
        console.log('check interval', fileInput.val())
        if (!fileInput.val()) return
        clearInterval(checkFileInterval)
        $('#imagePreview').attr('src', 'https://res.cloudinary.com/dkm5ywpkt/' + fileInput.val());
        $('#imagePreview').addClass('visible-img');
        $('#canAvatarLabel').addClass('visible-img');
    }  
    $('input[name="posterPath"]').val('')
    var checkFileInterval = setInterval(checkFileAndLoadPreview, 100)
})