<table>
    <tr>
        <th>Login</th>
        <th>Imie</th>
        <th>Nazwisko</th>
        <th>Poziom</th>
        <th>Losowanie</th>
        <th>Akcje</th>
    </tr>
    <?php
    $users = $this->get('users');
    foreach($users as $user) {
    ?>
    <tr>
        <td><?php print($user['username']);?></td>
        <td><?php print($user['name']);?></td>
        <td><?php print($user['surname']);?></td>
        <td><?php print($user['level']);?></td>
        <td><?php print($user['lottery']);?></td>
        <td>
            <?php if($user['level']==0) { ?>
                &nbsp;
            <?php } else { ?>
                <a href="javascript:void(0);" class="pageFont" onclick="delUserClick(<?php print("'".$user['username'])."'"?>)" ><img src="pages/images/delete.png" alt="delete" title="Usuń użytkownika"></a>
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
</table>