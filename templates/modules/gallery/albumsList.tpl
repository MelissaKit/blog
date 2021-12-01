<?php if($_SESSION['login']=='admin')
echo"<a class='btn btn-raised btn-danger btn-prof-set btn-add-review' href='/Gallery/AddAlbum/'>
<span class='glyphicon glyphicon-plus' aria-hidden='true'>Додати</span>
</a>"; ?>
<section id="gallery">
    <div>
        <div class="row gallery-container">
        <?php
        foreach($Params['Content'] as $key)
        {
        $path = $key['MainPhoto'];
        if($path=='')
        $path = '/files/standarts/default-album.jpg';
            echo "
                <div class='col-lg-4 col-xs-12 img-space'>";
            if($_SESSION['login']=='admin')
            echo"
            <div class='admin-panel gallery-panel'>
                <a class='btn btn-raised btn-danger btn-prof-set' href='/Gallery/DeleteAlbum/?Id=".$key['Id']."'>
                <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
                </a>
                <a class='btn btn-raised btn-danger btn-prof-set' href='/Gallery/EditAlbum/?Id=".$key['Id']."'>
                <span class='glyphicon glyphicon-edit' aria-hidden='true'></span>
                </a>
            </div>";
                echo "<div class='gallery'>
                    <a href='/Gallery/Open/?Id=".$key['Id']."'>
                        <img class='img-responsive' src='".$path."'/>
                        <span class='overlay'>{$key['Name']}</span>
                    </a>
                </div>
            </div>";
        }
echo"
        </div>
</section>";

echo "<div class='pagination-div'><ul class='pagination'>
        <li><a href='/Gallery/Index/?page=1'>«</a></li>
        ";
        for($i=1;$i<=$Params['PagesCount'];$i++)
        {
        if($Params['CurrentPage']==($i-1))
        echo "<li class='active'><a href='/Gallery/Index/?page=".$i."'>".$i."</a></li>";
        else
        echo"<li><a href='/Gallery/Index/?page=".$i."'>".$i."</a></li>";
        }
        echo("<li><a href='/Gallery/Index/?page=".$Params['PagesCount']."'>»</a></li></ul>");?>
</div>
?>