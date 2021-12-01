<div class="container prof-block">
    <div class="jumbotron review-container">
        <div class="row">
            <div class="col-md-8 col-xs-12 col-sm-6 col-lg-8 review-adding">
                <form class="form" method="post" action="/News/Add/" enctype="multipart/form-data">
                    <p><span class='fa fa-newspaper-o  fa-review'> Заголовок</span><input type='text' name='title' id='title' title='0-100 символів' pattern='.{0,100}'
                                                                               class='form-control' /></p>
                    <p><span class='fa fa fa-sticky-note-o fa-review'> Текст</span><textarea name='content' id='content'
                                                                                             class='form-control textarea-item'></textarea>
                    </p>
                    <p><span class='fa fa fa-file fa-review'> Постер</span>
                    <input type='file' name='poster' id='imageUpload' class='hide img-input form-control-file'/>
                    <label for='imageUpload' class='btn btn-large custom-file-label '>Додати фото</label>
                    <img src='' id='imagePreview' class='hid-img' alt='Preview Image'/>
                    <input type='button' name='canAvatar' id='canAvatar' class='hide'/>
                    <label for='canAvatar' class='btn btn-large custom-file-label hid-img btn-auto' id='canAvatarLabel'>Скинути</label>
                    <div><input type="submit" value="Створити" class="btn btn-block but-create"/></div>
                </form>
            </div>
        </div>
    </div>
</div>