<?php
/** @var yii\web\View $this */
use app\assets\AppAsset;

AppAsset::register($this);

$this->registerJsFile('https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js', [
    'position' => \yii\web\View::POS_HEAD,
]);

$this->title = 'Grand QR-code maker';
?>
    <span class="css-main-table">
      <span class="css-main-td">
        <span class="css-linkprocessor-block-wrapper">
            <span class="css-linkprocessor-qrfield">
                <span class="css-linkprocessor-qrfield-inner js-linkprocessor-qrfield">
                </span>
            </span>
        </span>

        <span class="css-linkprocessor-block-wrapper">
          <span class="css-linkprocessor-form">
            <input class="js-linkprocessor-form-input-link-check" type="text" placeholder="https://your.link" maxlength="170" />
            <button class="js-linkprocessor-form-button-check css-linkprocessor-form-button-send"><span class="js-linkprocessor-form-button-send-text-ok">ok</span></button>
          </span>
        </span>
      </span>
    </span>
