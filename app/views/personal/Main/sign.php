<?php if (isset($text)){
    echo $text;
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
                <th>User</th>
                <th>Action</th>
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
                        <td><span class="uk-badge my-button"><a class="uk-button uk-button-default" href="/personal/main/sign?id=<?=urlencode($db["hostname"]);?>">Sign</a></td>
                    </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>