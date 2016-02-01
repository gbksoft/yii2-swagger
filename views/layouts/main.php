<?php
use yii\helpers\Html;
use gbksoft\modules\swagger\SwaggerAsset;

/* @var $this \yii\web\View */
/* @var $content string */

SwaggerAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
  <script type="text/javascript">
    $(function () {
      var url = window.location.search.match(/url=([^&]+)/);
      if (url && url.length > 1) {
        url = decodeURIComponent(url[1]);
      } else {
        url = "<?= $this->context->module[gbksoft\modules\swagger\Module::MODULE_ID]->swaggerPath ?>";
      }

      // Pre load translate...
      if(window.SwaggerTranslator) {
        window.SwaggerTranslator.translate();
      }
      window.swaggerUi = new SwaggerUi({
        url: url,
        dom_id: "swagger-ui-container",
        supportedSubmitMethods: ['get', 'post', 'put', 'delete', 'patch'],
        onComplete: function(swaggerApi, swaggerUi){
          if(typeof initOAuth == "function") {
            initOAuth({
              clientId: "your-client-id",
              clientSecret: "your-client-secret-if-required",
              realm: "your-realms",
              appName: "your-app-name",
              scopeSeparator: ",",
              additionalQueryStringParams: {}
            });
          }

          if(window.SwaggerTranslator) {
            window.SwaggerTranslator.translate();
          }

          $('pre code').each(function(i, e) {
            hljs.highlightBlock(e)
          });

          addApiKeyAuthorization();


        },
        onFailure: function(data) {
          log("Unable to Load SwaggerUI");
        },
        docExpansion: "none",
        jsonEditor: false,
        apisSorter: "alpha",
        defaultModelRendering: 'schema',
        showRequestHeaders: true,
        /*,validatorUrl: "http://localhost:8002"*/
      });

      function addApiKeyAuthorization(){
        var key = encodeURIComponent( $('#input_apiKey')[0].value );
        if(key && key.trim() != "") {
            var apiKeyAuth = new SwaggerClient.ApiKeyAuthorization( "Authorization", "Bearer " + key, "header" );
            window.swaggerUi.api.clientAuthorizations.add( "bearer", apiKeyAuth );
            log( "Set bearer token: " + key );
        }
      }

      $('#input_apiKey').change(addApiKeyAuthorization);

      window.swaggerUi.load();

      function log() {
        if ('console' in window) {
          console.log.apply(console, arguments);
        }
      }
  });
  </script>
</head>
<body class="swagger-section">
<?php $this->beginBody() ?>
    <div id='header'>
      <div class="swagger-ui-wrap">
        <a id="logo" href="http://swagger.io">swagger</a>
        <form id='api_selector'>
            <div class='input'><input placeholder="http://example.com/api" id="input_baseUrl" name="baseUrl" type="text"/></div>
          <div class='input'><input placeholder="Authorization" id="input_apiKey" name="apiKey" type="text"/></div>
          <div class='input'><a id="explore" href="#" data-sw-translate>Explore</a></div>
        </form>
      </div>
    </div>

    <div id="message-bar" class="swagger-ui-wrap" data-sw-translate>&nbsp;</div>
    <div id="swagger-ui-container" class="swagger-ui-wrap"></div>

    <!-- API history block -->
    <div class="swagger-ui-wrap log-wrap">
        <h2>Short API History &mdash; last 10 swagger commits</h2>
        <div id="apihistory" class="wrap-log"></div>
    </div> <!-- End of API history block -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
