<?php
if ($_SESSION["loggened"]["role"] == 1){
?>
<div class="uk-flex uk-flex-center uk-flex-wrap uk-flex-wrap-around">
    <div class="uk-card uk-card-default uk-card-body mbtn-sgw">
        <span uk-icon="icon: plus-circle; ratio: 2"></span>
        <a href="/personal/main/issue">
            Issue certificate
        </a>
    </div>
    <div class="uk-card uk-card-default uk-card-body uk-margin-left mbtn-sgw">
        <span uk-icon="icon: trash; ratio: 2"></span>
        <a href="/personal/main/delete">
            Delete certificate
        </a>
    </div>
    <div class="uk-card uk-card-default uk-card-body uk-margin-left mbtn-sgw">
        <span uk-icon="icon: lock; ratio: 2"></span>
        <a href="/personal/main/sign">
            Sign certificates
        </a>
    </div>
    <div class="uk-card uk-card-default uk-card-body uk-margin-left mbtn-sgw">
        <span uk-icon="icon: future; ratio: 2"></span>
        <a href="/personal/main/renew">
            Renew certificates
        </a>
    </div>
    <div class="uk-card uk-card-default uk-card-body uk-margin-left mbtn-sgw">
        <span uk-icon="icon: download; ratio: 2"></span>
        <a href="/personal/main/export">
            Export certificates
        </a>
    </div>
</div>
<?php
}else{
?>
<div class="uk-flex uk-flex-center uk-flex-wrap uk-flex-wrap-around">
    <div class="uk-card uk-card-default uk-card-body mbtn-sgw">
        <span uk-icon="icon: plus-circle; ratio: 2"></span>
        <a href="/personal/main/issue">
            Issue certificate
        </a>
    </div>
    <div class="uk-card uk-card-default uk-card-body uk-margin-left mbtn-sgw">
        <span uk-icon="icon: download; ratio: 2"></span>
        <a href="/personal/main/export">
            Export certificates
        </a>
    </div>
</div>
<?php
}
?>