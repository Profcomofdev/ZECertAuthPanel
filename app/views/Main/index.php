<?php
if (isset($session)){
?>
<?php
}else{
?>
<div class="uk-flex uk-flex-center uk-flex-column">
    <h1 class="uk-heading-small header-login">Login to manage certificates</h1>
    <form action="/manage/main/auth" method="POST">
        <div class="uk-margin">
            <div class="uk-inline">
                <span class="uk-form-icon" uk-icon="icon: user"></span>
                <input class="uk-input input-username" type="text" name="username" placeholder="Username">
            </div>
        </div>
        <div class="uk-margin">
            <div class="uk-inline">
                <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                <input class="uk-input input-password" type="password" name="password" placeholder="Password">
            </div>
        </div>
        <div class="uk-flex uk-flex-center">
            <button class="uk-button uk-button-default uk-button-large login-btn" name="submit" value="Submitted">Login</button>
        </div>
    </form>
</div>
<?php
}
?>