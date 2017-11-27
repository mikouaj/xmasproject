<?php
$presents = $this->get('presents');
$isEditable = $this->get('isEditable');
$emptyTitle = $this->get('emptyTitle');
if(empty($presents)) {
    print("<p>".$emptyTitle."</p>");
} else { ?>
<table>
    <tr>
        <th>Nazwa</th>
        <th>Opis</th>
        <th>Link</th>
        <?php
            if($isEditable) { ?>
                <th>Akcja</th>
            <?php } ?>
    </tr>
    <?php
    foreach($presents as $present) {
    ?>
    <tr>
        <td><?php print($present['present']);?></td>
        <td><?php print($present['description']);?></td>
        <td><?php if(isset($present['link'])) {
                print("<a href=\"".$present['link']."\" target=\"_blank\" class=\"pageFont\">Link</a>");
            } else {
                print("-brak-");
            } ?></td>
        <td>
            <?php if($isEditable) { ?>
                <a href="javascript:void(0);" class="pageFont" onclick="delPresentClick(<?php print($present['id']);?>)"><img src="pages/images/delete.png" alt="delete" title="Usuń prezent"></a>
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
</table>
<?php } ?>