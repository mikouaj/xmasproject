<?php
$presents = $this->get('presents');
$isEditable = $this->get('isEditable');
$isReservationEnabled = $this->get('isReservationEnabled');
$currentUsername = $this->get('currentUsername');
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
            if($isEditable || $isReservationEnabled) { ?>
                <th>Akcja</th>
            <?php } ?>
    </tr>
    <?php
    foreach($presents as $present) {
      if(!empty($present['reservedBy']) && $present['reservedBy'] != $currentUsername) { ?>
        <tr style="text-decoration: line-through;" title="Prezent zarezerwowany">
      <?php } else { ?>
        <tr>
      <?php } ?>
        <td><?php print($present['present']);?></td>
        <td><?php print($present['description']);?></td>
        <td><?php if(isset($present['link'])) {
                print("<a href=\"".$present['link']."\" target=\"_blank\" class=\"pageFont\">Link</a>");
            } else {
                print("-brak-");
            } ?></td>
        <td>
            <?php if($isEditable) {   ?>
                <a href="javascript:void(0);" class="pageFont" onclick="delPresentClick(<?php print($present['id']);?>)"><img src="pages/images/delete.png" alt="delete" title="Usuń prezent"></a>
            <?php } ?>
            <?php if($isReservationEnabled && $present['username'] != $currentUsername) {
              if(empty($present['reservedBy'])) { ?>
                <a href="javascript:void(0);" class="pageFont" onclick="toggleReservationClick(<?php print($present['id']);?>)"><img src="pages/images/accept.png" alt="accept" title="Rezerwuj prezent"></a>
              <?php } elseif($present['reservedBy']==$currentUsername) { ?>
                <a href="javascript:void(0);" class="pageFont" onclick="toggleReservationClick(<?php print($present['id']);?>)"><img src="pages/images/arrow_undo.png" alt="arrow_undo" title="Usuń rezerwację"></a>
              <?php }
            } ?>
        </td>
    </tr>
    <?php } ?>
</table>
<?php } ?>
