<strong>Your facebook user access token:</strong><br />

<em>Copy this token into config/facebook-ads.php</em>

<hr />

<div id="access_token" style="display: inline-block; background-color: #ececec; border: 1px solid #ccc; padding: 5px;">
    Receiving...
    <noscript>Your browser does not support JavaScript - this is required in order to receive the access token</noscript>
</div>

<script type="text/javascript">
    var div = document.getElementById('access_token');
    var hash = window.location.hash;

    if (!hash) {
        alert('Invalid callback');
    }

    var accessToken = hash.match(/access_token=(.*)&/i);

    if (!accessToken.length > 1) {
        alert('Invalid callback');
    }

    div.innerText = accessToken[1];
</script>