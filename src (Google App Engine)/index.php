<?php

include 'config.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tom Scott's Amazing Places - A Website By VerifiedJoseph</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>
    <div class="container" id="main">
        <div class="row e e-footer">
            <div class="col-md-12"><span class="website-note">This is a unofficial website created by VerifiedJoseph. For Tom Scott's website <a target="_blank" title="Tom scott's official website (tomscott.com)" href="https://tomscott.com">click here</a></span></div>
        </div>
        <div class="row h">
            <div class="col-md-12">
                <h2><img src="images/name_ap_97.png" alt="Tom Scott's Amazing Places" style="width:503px;max-width:100%"></h2></div>
        </div>
        <div class="row e">
            <div class="col-md-12">
                <h4>Showcasing some the world's most amazing &amp; unique places.</h4></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="map-container" data-map-load="true" data-url="<?php echo $root_url; ?>">
                    <div id="error-note">
                        <div class="alert alert-dismissible alert-danger"><span title="Technobabble from scifiideas.com/technobabble-generator"><strong>Oh snap!</strong> The supersonic pulse reactor has uncoupled from the shift compressor.</span>
                            <h6>In english please?? locations.json failed to load, press F5 to reload the page and try agin.</h6></div>
                    </div>
                    <div id="map-canvas"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="pull-left">
                    <h2>The Videos <span class="badge"></span></h2>
                    <h5>Click a video to view it on the map. </h5></div>
            </div>
        </div>
        <div class="row video-box"></div>
        <div id="stuff" class="row">
            <div class="col-md-4">
                <h2>Tom's YouTube Channel</h2>
                <h5>Have you subscribed yet?</h5>
                <div class="subscribe">
                    <a href="https://www.youtube.com/channel/UCBa659QWEk1AI4Tg--mrJ2A?sub_confirmation=1"><img src="images/subscribe-button.png" title="Click to subscribe" /></a>
                </div>
            </div>
            <div class="col-md-4">
                <h2>Social Media</h2>
                <p><a target="_blank" href="https://twitter.com/tomscott">Twitter</a>, <a target="_blank" href="https://facebook.com/tomscott">Facebook</a> or <a target="_blank" href="https://plus.google.com/+TomScottGo">Google+</a></p>
            </div>
            <div class="col-md-4">
                <h2>Website</h2>
                <p><a target="_blank" title="Tom's official website" href="https://tomscott.com">tomscott.com</a></p>
            </div>
        </div>
        <div class="row e e-footer">
            <div class="col-md-12">
                <h5>Tom Scott's Amazing Places was created by VerifiedJoseph. <a target="_blank" href="https://twitter.com/VerifiedJoseph">Twitter</a></h5>
                <h6>This website is not sponsored, owned, or endorsed by Tom Scott, In other words it's unofficial</h6></div>
        </div>
    </div>
    <script src="js/jquery-2.2.0.min.js"></script>
    <script src="js/jquery.dotdotdot.min.js"></script>
    <script src="js/frontend.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $map_key; ?>"></script>
    <script>
        (function(d, e, j, h, f, c, b) {
            d.GoogleAnalyticsObject = f;
            d[f] = d[f] || function() {
                (d[f].q = d[f].q || []).push(arguments)
            }, d[f].l = 1 * new Date();
            c = e.createElement(j), b = e.getElementsByTagName(j)[0];
            c.async = 1;
            c.src = h;
            b.parentNode.insertBefore(c, b)
        })(window, document, "script", "//www.google-analytics.com/analytics.js", "ga");
        ga("create", "UA-27289094-8", "auto");
        ga("send", "pageview");
    </script>
</body>
</html>