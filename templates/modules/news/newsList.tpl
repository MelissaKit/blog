<?php if($_SESSION['login']=='admin')
echo"<a class='btn btn-raised btn-danger btn-prof-set btn-add-review' href='/News/Add/'>
    <span class='glyphicon glyphicon-plus' aria-hidden='true'>Додати</span>
</a>"; ?>
<div class="row content-row">
    <?php
    foreach($Params['Content'] as $key)
    {
    $path = $key['PosterPath'];
    if($path=='')
        $path = '/files/standarts/newsPoster.png';
    echo "<div class='col-sm-6'>";
    if($_SESSION['login']=='admin')
    echo"
    <div class='admin-panel'>
        <a class='btn btn-raised btn-danger btn-prof-set' href='/News/Delete/?Id=".$key['Id']."'>
        <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
        </a>
        <a class='btn btn-raised btn-danger btn-prof-set' href='/News/Edit/?Id=".$key['Id']."'>
        <span class='glyphicon glyphicon-edit' aria-hidden='true'></span>
        </a>
    </div>";
    echo "
    <div class='img-container news-image'><img class='film-poster' src='".$path."'></div>
    <div class='news-container text-container'><a class='film-link news-title'>".$key['Title']."</a>
        <div class='news-content'><span>".$key['Content']."</span></div></div>
</div>";
}
echo "</div>";

echo "<div class='pagination-div'><ul class='pagination'>
        <li><a href='/News/Index/?page=1'>«</a></li>
        ";
        for($i=1;$i<=$Params['PagesCount'];$i++)
        {
        if($Params['CurrentPage']==($i-1))
        echo "<li class='active'><a href='/News/Index/?page=".$i."'>".$i."</a></li>";
        else
        echo"<li><a href='/News/Index/?page=".$i."'>".$i."</a></li>";
        }
        echo("<li><a href='/News/Index/?page=".$Params['PagesCount']."'>»</a></li></ul>");?>
</div>

