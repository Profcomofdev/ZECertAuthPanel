<form method="POST">
    <div uk-form-custom class="ma-width-500 uk-flex">
        <input type="hostname" placeholder="test.host" name="hostname" class="uk-input">
        <button class="uk-button uk-button-default" type="submit">Submit</button>
    </div>
</form>
<?php if (isset($text)){
    echo $text;
}
/*
[ 
'hostname' => $hostname, 
'csr' => $csr_path, 
'key' => $key_result,
'crt' => '',
'user' => $username,
]
*/
?>
<div style="width:100%; overflow:auto;">
    <table class="uk-table uk-table-divider">
        <thead>
            <tr>
                <th>Hostname</th>
                <th>Issued</th>
                <th>Key</th>
                <th>Certificate</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($database as $db){
                $csr = 'Exists';
                $key = 'Exists';
                $crt = 'Exists';
                if ($db["csr"] == ''){
                    $csr = 'Nothing';
                }
                if ($db["key"] == ''){
                    $key = 'Nothing';
                }
                if ($db["crt"] == ''){
                    $crt = 'Nothing';
                }
                ?>
                    <tr>
                        <td><?=$db["hostname"];?></td>
                        <td><span class="uk-badge <?=$csr;?>"><?=$csr;?></span></td>
                        <td><span class="uk-badge <?=$key;?>"><?=$key;?></span></td>
                        <td><span class="uk-badge <?=$crt;?>"><?=$crt;?></span></td>
                        <td><span class="uk-badge"><?=$db["user"];?></span></td>
                    </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>