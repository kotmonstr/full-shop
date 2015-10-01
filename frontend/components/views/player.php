<?php
use yii\web\View;
use yii\web\AssetBundle;
?>

<?php

$this->registerJsFile('/js/last/jquery.js', [AssetBundle::className()]);
$this->registerJsFile('/player/video.js', [AssetBundle::className()]);
$this->registerCssFile('/player/video-js.css');
$this->registerJsFile('/player/video-init.js', [View::POS_END]);
?>

<h3>Player</h3

<!--<video id="example_video_1" class="video-js vjs-default-skin" controls preload="none" width="640" height="264"-->
<!--       poster="http://video-js.zencoder.com/oceans-clip.png"-->
<!--       data-setup="{}">-->
<!--    <source src="http://video-js.zencoder.com/oceans-clip.mp4" type='video/mp4' />-->
<!--    <source src="http://video-js.zencoder.com/oceans-clip.webm" type='video/webm' />-->
<!--    <source src="http://video-js.zencoder.com/oceans-clip.ogv" type='video/ogg' />-->
<!--    <track kind="captions" src="demo.captions.vtt" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->-->
<!--    <track kind="subtitles" src="demo.captions.vtt" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->-->
<!--    <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>-->
<!--</video>-->


<video id="example_video_2" class="video-js vjs-default-skin"
       controls preload="true" width="640" height="480"
<!--       poster="http://video-js.zencoder.com/oceans-clip.png"-->
<!--       data-setup='{"example_option":true}'>-->
    <source src="/video/3.mpg" type='video/mp4' />
    ...
</video>





