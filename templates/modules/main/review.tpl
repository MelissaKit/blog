<div class="container prof-block">
    <div class="jumbotron review-container">
        <div class="row">
            <div class="col-md-4 col-xs-12 col-sm-6 col-lg-4">
                <div class="prof-img-container">
                    <img
                    <?php if($Params['PosterPath']=='')
                        echo "src='/files/standarts/reviewPoster.jpg'";
                    else
                        echo "src='".$Params['PosterPath']."'";?>
                    alt="photo" class="img">
                </div>
                <div>
                    <?php
                    if(isset($Params['PublicationDate']) && $Params['PublicationDate']!='0000-00-00' )
                    echo"
                    <p><span class='fa fa-calendar-plus-o'></span>".$Params['PublicationDate']."</p>
                    ";?>
                </div>
            </div>
            <div class="col-md-8 col-xs-12 col-sm-6 col-lg-8">
                <div class="container prof-container">
                    <h2><?php if(isset($Params['Name'])) echo $Params['Name'];?></h2>
                </div>
                <hr>
                <ul class="container details">
                    <?php
                    if(isset($Params['Country']) && ($Params['Country'])!='' )
                    echo"
                    <li><p><span class='fa fa-globe fa-review'></span>".$Params['Country']."</p></li>
                    ";
                    ?>
                </ul>
            </div>
            <div class="review-text">
                <p><?php
                    if(isset($Params['Text']) && $Params['Text']!='')
                    echo $Params['Text'];?>
                </p>
            </div>
        </div>
    </div>
</div>