<div class="container page-top">
    <div class="row">
        <?php
        foreach($Params['Content'] as $key)
        {
        echo"
            <div class='col-lg-3 col-md-4 col-xs-6 thumb'>
                <a class='fancybox'>
                    <img  src='".$key['Path']."' class='zoom img-fluid '  alt=''>
                </a>
            </div>";
        }
        echo"
    </div>
</div>";
echo "<div class='pagination-div'><ul class='pagination'>
        <li><a href='/Gallery/Open/?Id=".$Params['AlbumId']."&page=1'>«</a></li>
        ";
        for($i=1;$i<=$Params['PagesCount'];$i++)
        {
        if($Params['CurrentPage']==($i-1))
        echo "<li class='active'><a href='/Gallery/Open/?Id=".$Params['AlbumId']."&page=".$i."'>".$i."</a></li>";
        else
        echo"<li><a href='/Gallery/Open/?Id=".$Params['AlbumId']."&page=".$i."'>".$i."</a></li>";
        }
        echo("<li><a href='/Gallery/Open/?Id=".$Params['AlbumId']."&page=".$Params['PagesCount']."'>»</a></li></ul>");?>
</div>