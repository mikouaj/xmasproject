<h1>Losowanie</h1>
<?php
    $lotteryActive = $this->get('lotteryActive');
    if($lotteryActive) {
        ?><p>Losowanie jest aktywne. <a href="javascript:void(0);" onclick="stopLotteryClick()" class="pageFont">Zatrzymaj</a></p> <?php
    } else {
        ?><p>Losowanie jest nieaktywne. <a href="javascript:void(0);" onclick="startLotteryClick()" class="pageFont">Uruchom</a></p> <?php
    }
?>