<?php
/**
 *
 * @package    cookie-disclaimer
 * @author     vitaly
 * @var array $options
 */ ?>
<div class="cookie-disclaimer-holder" id="cookie-disclaimer-holder">
    <div class="cd-close cd-accept-action"></div>
    <p><?= $options['cookie_statement'] ?></p>
    <p><?= $options['site_ownership_default'] ?></p>
    <button class="cd-accept-button cd-accept-action"
            title="<?= esc_attr( $options['accept_button'] ) ?>"><?= $options['accept_button'] ?></button>
</div>
<style>
    .cookie-disclaimer-holder {
        border: 4px solid <?= $options['base-color'] ?>;
        position: fixed;
        bottom: 0;
        right: 0;
        background: white;
        padding: 25px 15px;
        width: 254px;
        box-sizing: border-box;
        z-index: 100;
    }

    @media (max-width: 767px) {
        .cookie-disclaimer-holder {
            display: none;
        }
    }

    html[dir="rtl"] .cookie-disclaimer-holder,
    .rtl .cookie-disclaimer-holder {
        left: 0;
        right: auto;
    }

    .cookie-disclaimer-holder p {
        font-size: 0.75em;
    }

    .cookie-disclaimer-holder .cd-accept-button {
        max-width: 211px;
        display: block;
        margin: 0 auto;
        box-sizing: border-box;
        background-color: <?= $options['base-color'] ?>;
        border: 4px solid <?= $options['base-color'] ?>;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #000000;
        font-size: 14px;
        line-height: 20px;
        padding: 5px 15px;
        font-weight: normal;
    }

    .cookie-disclaimer-holder .cd-accept-button:hover {
        background-color: white;
        color: <?= $options['base-color'] ?>;
    }

    .cd-close {
        top: 9px;
        right: 13px;
        width: 15px;
        height: 15px;
        position: absolute;
        cursor: pointer;
        transition: transform 0.5s;
    }

    html[dir="rtl"] .cd-close,
    .rtl .cd-close {
        right: auto;
        left: 13px;
    }

    .cd-close:hover {
        transform: rotate(-180deg);
    }

    .cd-close:before, .cd-close:after {
        position: absolute;
        left: 7px;
        content: ' ';
        height: 15px;
        width: 2px;
        background-color: #AEAEAE;
    }

    .cd-close:before {
        transform: rotate(45deg);
    }

    .cd-close:after {
        transform: rotate(-45deg);
    }
</style>
<script>
    jQuery(function ($) {
        var $holder = $('#cookie-disclaimer-holder');
        $holder.find('.cd-accept-action').on('click', function (e) {
            e.preventDefault();
            document.cookie = "cookie-disclaimer-accepted=1; path=/";
            $holder.remove();
        });
    });
</script>