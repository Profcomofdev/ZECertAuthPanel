<!DOCTYPE html>
<html>
    <head>    
        <title>Error</title>
        <meta charset="UTF-8">
        <style>
            html {
                height: 100%;
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            body {
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .errors {
                background: #fff;
                border: 1px solid #dedede;
            }

            .error_t {
                font-size: 20px;
                text-align: center;
                padding: 10px 20px;
            }

            .error_fields {
                display: flex;
                justify-content: space-between;
                background: #fff;
                padding: 10px 20px;
                border: 1px solid #dedede;
                margin: 10px 20px;
                align-items: center;
            }

            pre{
                max-width: 100%;
                overflow:auto;
            }
    </style>
    </head>
    <body>
        <div class="errors">
            <div class="error_t">An error occured</div>
            <div class="error_fields">
                <div class="error__code"><b>Error code</b></div>
                <div class="error_text"><?= $errno ?></div>
            </div>
            <div class="error_fields">
                <div class="error__code"><b>Error text</b></div>
                <div class="error_text"><pre><?= $errstr ?></pre></div>
            </div>
            <div class="error_fields">
                <div class="error__code"><b>Error file</b></div>
                <div class="error_text"><pre><code><?= $errfile ?></code></pre></div>
            </div>
            <div class="error_fields">
                <div class="error__code"><b>Error line</b></div>
                <div class="error_text"><?= $errline ?></div>
            </div>
        </div>
    </body>
</html>