<div class="error"><p>
    <?php if(isset($Params['Error'])) echo $Params['Error'];?>
    </p>
</div>
<div class="row centered-form">
    <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="regTitle">Реєстрація</h4>
            </div>
            <div class="panel-body">
                <form class="form" method="post" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" required name="login" id="login" class="form-control required"  pattern=".{2,50}" title="2-50 символів"
                               placeholder="Логін">
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,60}" title="Має містити символи різних регістрів та як мінімум 6 символів" type="password" required name="password" id="password" class="form-control required"
                                       placeholder="Пароль">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="password" required name="passwordConfirm" id="passwordConfirm"
                                       class="form-control required" placeholder="Пароль ще раз">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="firstName" id="firstName"  pattern=".{0,50}" title="2-50 символів"
                                       class="form-control" placeholder="Ім'я">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="secondName" id="secondName" class="form-control" pattern=".{0,50}" title="2-50 символів"
                                       placeholder="Прізвище">
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <input type="email" required name="mail" id="mail" class="form-control required" pattern="[A-Za-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"
                               placeholder="Email" >
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="country" id="country"  pattern=".{0,40}" title="2-40 символів"
                                       class="form-control" placeholder="Країна">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="city" id="city" class="form-control"   pattern=".{0,40}" title="2-40 символів"
                                       placeholder="Місто">
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="date" name="birthDate" id="birthDate" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group ">
                                <label class="regLabel">Дата народження</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="">
                                <input type="file" name="avatar" id="imageUpload" class="hide"/>
                                <label for="imageUpload" class="btn btn-large custom-file-label ">Фото профіля</label>
                                <img src="" id="imagePreview" class="hid-img" alt="Preview Image"/>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group ">
                                <input type="button" name="canAvatar" id="canAvatar" class="hide" width="50px" height="50px"/>
                                <label for="canAvatar" class="btn btn-large custom-file-label hid-img" id="canAvatarLabel">Скинути</label>                               </div>
                        </div>
                    </div>

                    <input type="submit" value="Зареєструватися" class="btn btn-block regBut">
                </form>
            </div>
        </div>
    </div>
</div>