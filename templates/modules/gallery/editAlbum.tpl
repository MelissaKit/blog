<div class="container prof-block">
    <div class="jumbotron review-container">
        <div class="row">
            <div class="col-md-4 col-xs-12 col-sm-6 col-lg-4">
                <div class="prof-img-container">
                    <img
                    <?php if($Params['MainPhoto']=='')
                        echo "src='/files/standarts/default-album.jpg'";
                    else
                        echo "src='".$Params['MainPhoto']."'";?>
                    alt="photo" class="img">
                </div>
            </div>
            <div class="col-md-8 col-xs-12 col-sm-6 col-lg-8">
                <form class="form" method="post" action="/Gallery/EditAlbum/?Id=<?php echo $Params['Id']?>" enctype="multipart/form-data">
                    <?php echo"
                    <p><span class='fa fa-newspaper-o  fa-review'> Hазва</span><input type='text' name='name' id='name' title='0-50 символів'pattern='.{0,50}'
                                                                                      class='form-control' value='".$Params['Name']."'/></p>"; ?>
                    <p><span class='fa fa fa-review fa fa-image'> Обгортка</span>
                    <input type='file' name='mainPhoto' id='imageUpload' class='hide img-input form-control-file'/>
                    <label for='imageUpload' class='btn btn-large custom-file-label '>Змінити</label>
                    <img src='' id='imagePreview' class='hid-img' alt='Preview Image'/>
                    <input type='button' name='canAvatar' id='canAvatar' class='hide'/>
                    <label for='canAvatar' class='btn btn-large custom-file-label hid-img btn-auto' id='canAvatarLabel'>Скинути</label>
                        <br><span class="fa-review fa">Видалити обгортку</span>
                        <label for='info' class='btn custom-file-label'>Видалити<input type='checkbox' id='info'  name='delMainPhoto' class='badgebox'><span class='badge'>&check;</span></label>
                    </p>
                    <p><span class='fa fa-camera fa-review'> Фотографії</span><br>
                    <span class="fa">Додати</span>
                        <input type='file' name='pictures[]' id='imagesUpload' multiple
                               class='hide img-input form-control-file'/>
                        <label for='imagesUpload' class='btn btn-large custom-file-label '>Додати фото альбому</label>
                        <span id='imagesPreview' class='hid-img fa-review' >Фото обрано</span>
                        <input type='button' name='canPhotos' id='canPhotos' class='hide'/>
                        <label for='canPhotos' class='btn btn-large custom-file-label hid-img btn-auto'
                               id='canPhotosLabel'>Скинути</label></p>

                        <p><span class="fa">Видалити</span>

                    <?php
                        foreach($Params['photos'] as $photo)
                        {
                            echo "<div class='inline-div'><img class='oldPhoto' src='".$photo['Path']."'><input class='checkphoto' type='checkbox' name='delPhoto[]' id='delPhoto' value='".$photo['Id']."'/></div>";
                        }
                    ?>
                    <div><input type="submit" value="Редагувати" class="btn btn-block but-create btn-start"/></div>
                </form>
            </div>
        </div>
    </div>
</div>