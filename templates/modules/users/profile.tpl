<div class="container prof-block">
    <div class="jumbotron">
        <div class="row">
            <div class="col-md-4 col-xs-12 col-sm-6 col-lg-4">
                <div class="prof-img-container">
                    <img
                    <?php if($Params['AvatarPath']=='')
                        echo "src='/files/standarts/ava.png'";
                    else
                        echo "src='".$Params['AvatarPath']."'";?>
                         alt="photo" class="img">
                </div>
                <div class="float-left small prof-but">
                    <a class="btn btn-raised btn-danger btn-prof-set" href="/Users/DeleteUser/">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </a>
                    <a class="btn btn-raised btn-danger btn-prof-set" href="/Users/EditProf/">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                    </a>
                </div>
            </div>
            <div class="col-md-8 col-xs-12 col-sm-6 col-lg-8">
                <div class="container prof-container">
                    <h2><?php echo $Params['FirstName']." ".$Params['SecondName'];?></h2>
                </div>
                <hr>
                <ul class="container details">
                    <?php
                    echo "<li><p><span class='glyphicon glyphicon-user one prof-icon'></span>".$Params['Login']."
                    </p></li>";
                    echo "
                    <li><p><span class='glyphicon glyphicon-envelope one prof-icon'></span>".$Params['Mail']."</p></li>
                    ";
                    if(isset($Params['Country']) && $Params['Country']!='')
                    echo"
                    <li><p><span class='glyphicon glyphicon-globe prof-icon'></span>".$Params['Country']."</p></li>
                    ";
                    if(isset($Params['City']) && $Params['City']!='')
                    echo"
                    <li><p><span class='glyphicon glyphicon-map-marker one prof-icon'></span>".$Params['City']."</p>
                    </li>
                    ";
                    if(isset($Params['BirthDate']) && $Params['BirthDate']!='0000-00-00')
                    echo"
                    <li><p><span class='glyphicon glyphicon-calendar prof-icon'></span>".$Params['BirthDate']."</p></li>
                    ";
                    ?>
                </ul>
            </div>
        </div>
    </div>