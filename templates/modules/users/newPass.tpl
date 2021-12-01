<div class="error"><p>
        <?php if(isset($Params['Error'])) echo $Params['Error'];?>
    </p>
</div>
<div class="row centered-form">
    <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="logTitle">Введіть новий пароль</h4>
            </div>
            <div class="panel-body">
                <form class="form" method="post" action="">
                    <div class="form-group">
                        <input type="password" name="newPassword" id="newPassword"
                               class="form-control" placeholder="Новий пароль">
                    </div>
                    <div class="form-group">
                        <input type="password" name="newPasswordConfirm" id="newPasswordConfirm" class="form-control"
                               placeholder="Підтвердження пароля">
                    </div>
                    <input type="submit" value="Підтвердити" class="btn btn-block logBut">
                </form>
            </div>
        </div>
    </div>
</div>