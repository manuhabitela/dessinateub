<script>
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://<?php echo APP_PIWIK_SERVER ?>//";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', <?php echo APP_PIWIK_ID ?>]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
    g.defer=true; g.async=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="http://<?php echo APP_PIWIK_SERVER ?>/piwik.php?idsite=<?php echo APP_PIWIK_ID ?>" style="border:0" alt="" /></p></noscript>