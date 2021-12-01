<select id="search">
    <option value="reviews" selected>Огляди</option>
    <option value="news">Новини</option>
    <option value="gallery">Галерея</option>
</select>


<div id="search-result">
<div id="reviews">
<div class="row content-row review-block">
    <?php
    foreach($Params['reviews'] as $key)
    {
    $path = $key['PosterPath'];
    if($path=='')
        $path = '/files/standarts/reviewPoster.jpg';
    echo "<div class='col-sm-3'>";
    echo"<div class='img-container'><img class='film-poster' src='".$path."'></div>
    <div class='text-container'><a class='film-link' href='/Main/Show/?Id=".$key['Id']."'>".$key['Name']."</a></div>
</div>";
}
echo "</div></div>
<div id='news' class='search-hidden'>
<div class='row content-row'>";
    foreach($Params['news'] as $key)
    {
    $path = $key['PosterPath'];
    if($path=='')
        $path = '/files/standarts/newsPoster.png';
    echo "<div class='col-sm-6'>
    <div class='img-container news-image'><img class='film-poster' src='".$path."'></div>
    <div class='news-container text-container'><a class='film-link news-title'>".$key['Title']."</a>
        <div class='news-content'><span>".$key['Content']."</span></div></div>
</div>";
}
    echo "</div></div>
<div id='gallery' class='search-hidden'>
<section id='gallery'>
    <div>
        <div class='row gallery-container'>";
        foreach($Params['gallery'] as $key)
        {
        $path = $key['MainPhoto'];
        if($path=='')
        $path = '/files/standarts/default-album.jpg';
            echo "
                <div class='col-lg-4 col-xs-12 img-space'>
                <div class='gallery'>
                <a href='/Gallery/Open/?AlbumId=".$key['Id']."'>
                <img class='img-responsive' src='".$path."'/>
                <span class='overlay'>{$key['Name']}</span>
                </a>
            </div>
        </div>";
        }
        echo "
        </div>
</section>
</div>
</div>";