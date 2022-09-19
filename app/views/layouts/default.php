<!DOCTYPE html>
<html lang="en">
    <head>
        <title>ZECertAuthPanel</title>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" href="/public/assets/css/main.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/public/assets/css/uikit.min.css" />
        <script src="/public/assets/js/uikit.min.js"></script>
        <script src="/public/assets/js/uikit-icons.min.js"></script>
    </head>
    <body>
        <nav class="uk-navbar-container uk-margin uk-padding-small uk-padding-remove-top uk-padding-remove-bottom" uk-navbar>
            <div class="uk-navbar-left">
                <a class="uk-navbar-toggle" href="#">
                    <span uk-navbar-toggle-icon></span> <span class="uk-margin-small-left">Menu</span>
                </a>
                <a class="uk-navbar-item uk-logo" href="/manage/"><img src="/public/assets/images/logo.svg"/></a>
                <ul class="uk-navbar-nav">
                    <li>
                        <a href="/manage/certificates">
                            All Certificates
                        </a>
                    </li>
                    <li>
                        <a href="/manage/renew">
                            Renew Certificates
                        </a>
                    </li>
                    <li>
                        <a href="/manage/ca">
                            Default CA
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <main id="main" class="main">
            <?=$content;?>
        </main>
    </body>
</html>