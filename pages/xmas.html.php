<?php include 'pages/header.html.php'; ?>
<div id="pagecontent" class="pageFont">
    <div id="mainmenu">
        <table>
            <?php
                $hasLottery = $this->get('hasLottery');
                if($hasLottery) {
            ?>
            <tr>
                <td style="text-align:center"><img src="pages/images/elf2.png" alt="elf"></td>
                <td>
                    <?php
                        $isLotteryActive = $this->get('isLotteryActive');
                        if(!$isLotteryActive) {
                            ?> <p>Losowanie nie jest jeszcze aktywne!</p> <?php
                        } else {
                            $randomUser = $this->get('randomUserData');
                            if(!empty($randomUser)) {
                                ?> <p>Osoba którą wylosowałeś to <?php print($randomUser['name']." ".$randomUser['surname']);?> !</p>
                                <p><a href="index.php?presents&user=<?php print($randomUser['username']);?>">Sprawdź o czym marzy <?php print($randomUser['name']);?></a></p> <?php
                            } else {
                                ?> <p> Nie brałeś jeszcze udziału w losowaniu. <a class="pageFont" href="javascript:void(0);" onclick="randomUserClick()">LOSUJ</a></p> <?php
                            }
                        }
                    ?>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td style="text-align:center"><img src="pages/images/sock2.png" alt="sock"></td>
                <td><a href="index.php?presents" class="pageFont">Moja lista prezentów</a></td>
            </tr>
            <?php
            if($userModel->hasSantaAccess()) {
            ?>
            <tr>
                <td style="text-align:center"><img src="pages/images/santa.png" alt="santa"></td>
                <td><a href="index.php?admin" class="pageFont">Panel św. Mikołaja</a></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>
<div id="dialog-random" class="dialog" title="Losowanie">
    <p>Uwaga zaczynam losować osobę!</p>
    <p>Pamietaj że po losowaniu nie ma zmian :-)</p> 
</div>
<div id="dialog-randomAck" class="dialog" title="Losowanie">
    <p>Losowanie przebiegło pomyślnie!</p>
</div>
<script>
    function randomUserClick() {
        $("#dialog-random").dialog({
            resizable: false,
            modal: true,
            autoOpen: true,
            buttons: {
                "Ok": function() {
                    randomUser();
                    $( this ).dialog("close");
                },
                "Anuluj": function() {
                    $( this ).dialog("close");
                }
            }
        }); 
    }
    function randomUser() {
        $.get("index.php?lottery&a=random", function( data ) {
            var errorcontent = $('#errorcontent', $.parseHTML(data));
            if (typeof(errorcontent.html()) === 'undefined') {   
                $("#dialog-randomAck").dialog({
                        resizable: false,
                        modal: true,
                        autoOpen: true,
                        buttons: {
                            "Ok": function() {
                                $( this ).dialog("close");
                            }
                        },
                        close: function() {
                            location.reload();
                        }   
                });
            } else {
                document.write(data);
            }     
        });   
    }
</script>
<?php include 'pages/footer.html.php'; ?>