const removeAvatar = (selector) => () => {
    $('#canAvatarLabel').removeClass('visible-img');
    $('#imagePreview').removeClass('visible-img');
    $(selector).val('')
    $(selector).wrap('<form>').closest('form').get(0).reset();
    $(selector).unwrap();
}

$("#canAvatar").click(removeAvatar('input[name="posterPath"]'));
$("#canAvatar").click(removeAvatar('input[name="avatarPath"]'));


const preview = (selector) => () => {
    checkFileAndLoadPreview = function () {
        const fileInput = $(selector)
        console.log('check interval', fileInput.val())
        if (!fileInput.val()) return
        clearInterval(checkFileInterval)
        $('#imagePreview').attr('src', 'https://res.cloudinary.com/dkm5ywpkt/' + fileInput.val());
        $('#imagePreview').addClass('visible-img');
        $('#canAvatarLabel').addClass('visible-img');
    }
    $(selector).val('')
    var checkFileInterval = setInterval(checkFileAndLoadPreview, 100)
}

$('label[for="posterPath"]').click(preview('input[name="posterPath"]'))
$('label[for="avatarPath"]').click(preview('input[name="avatarPath"]'))