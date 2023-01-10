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
if ($certf){
?>
<div class="show_code">
    <pre class="code">
        <?=$certf;?>
    </pre>
</div>
<?php
}
?>
<div style="width:100%; overflow:auto;">
    <table class="uk-table uk-table-divider">
        <thead>
            <tr>
                <th>Hostname</th>
                <th>Issued</th>
                <th>Key</th>
                <th>Certificate</th>
                <th>Archive</th>
                <th>User:archive-password</th>
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
                        <td><span class="uk-badge"><a href="/personal/main/export?hostname=<?=$db["hostname"];?>&type=csr">Show request</a></span></td>
                        <td><span class="uk-badge"><a href="/personal/main/export?hostname=<?=$db["hostname"];?>&type=key">Show key</a></span></td>
                        <td><span class="uk-badge"><a href="/personal/main/export?hostname=<?=$db["hostname"];?>&type=crt">Show certificate</a></span></td>
                        <td><span class="uk-badge"><a href="/download/?name=<?=$db["hostname"];?>&type=p12" password="<?=$db["password"];?>" onclick="downloadParchive(this);">Download p12</a></span></td>
                        <td><span class="uk-badge"><?=$db["user"];?>:<?=$db["password"];?></span></td>
                    </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>