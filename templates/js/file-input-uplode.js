$('#imageUpload').change(function () {
    readImgUrlAndPreview(this);

    function readImgUrlAndPreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imagePreview').attr('src', e.target.result);
                $('#imagePreview').addClass('visible-img');
                $('#canAvatarLabel').addClass('visible-img');
            }
        }
        ;
        reader.readAsDataURL(input.files[0]);
    }
});

$("#canAvatar").click(function () {
    $('#canAvatarLabel').removeClass('visible-img');
    $('#imagePreview').removeClass('visible-img');
    $('#imageUpload').wrap('<form>').closest('form').get(0).reset();
    $('#imageUpload').unwrap();
});

$('#imagesUpload').change(function () {
    readImgUrlAndPreview(this);

    function readImgUrlAndPreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imagesPreview').addClass('visible-img');
                $('#canPhotosLabel').addClass('visible-img');
            }
        }
        ;
        reader.readAsDataURL(input.files[0]);
    }
});

$("#canPhotos").click(function () {
    $('#canPhotosLabel').removeClass('visible-img');
    $('#imagesPreview').removeClass('visible-img');
    $('#imagesUpload').wrap('<form>').closest('form').get(0).reset();
    $('#imagesUpload').unwrap();
});