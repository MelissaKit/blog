<div class="container prof-block">
    <div class="jumbotron review-container">
        <div class="row">
            <div class="col-md-8 col-xs-12 col-sm-6 col-lg-8 review-adding">
                <form class="form" method="post" action="/Gallery/AddAlbum/" enctype="multipart/form-data">
                    <p><span class='fa fa-newspaper-o  fa-review'> Hазва</span><input type='text' name='name' id='name' title='0-50 символів' pattern=".{0,50}"
                                                                                      class='form-control'/></p>
                    <p><span class='fa fa fa-review fa fa-image'> Обгортка</span><input type='file' name='mainPhoto'
                                                                                        id='imageUpload'
                                                                                        class='hide img-input form-control-file'/>
                        <label for='imageUpload' class='btn btn-large custom-file-label '>Додати головне фото</label>
                        <img src='' id='imagePreview' class='hid-img' alt='Preview Image'/>
                        <input type='button' name='canAvatar' id='canAvatar' class='hide'/>
                        <label for='canAvatar' class='btn btn-large custom-file-label hid-img btn-auto'
                               id='canAvatarLabel'>Скинути</label></p>
                    <p><span class='glyphicon glyphicon-camera fa-review'> Фотографії</span>
                        <input type='file' name='pictures[]' id='imagesUpload' multiple
                               class='hide img-input form-control-file'/>
                        <label for='imagesUpload' class='btn btn-large custom-file-label '>Додати фото альбому</label>
                        <span id='imagesPreview' class='hid-img' >Фото обрано<span/>
                        <input type='button' name='canPhotos' id='canPhotos' class='hide'/>
                        <label for='canPhotos' class='btn btn-large custom-file-label hid-img btn-auto'
                               id='canPhotosLabel'>Скинути</label></p>
                    </p>
                    <div><input type="submit" value="Створити" class="btn btn-block but-create"/></div>
                </form>
            </div>
        </div>
    </div>
</div>