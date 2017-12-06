<?php include 'pages/header.html.php'; ?>
<div id="pagecontent" class="pageFont">
    <div id="navpath">
        <p>Jesteś w panelu św. Mikołaja (<a href="index.php?xmas" class="pageFont">Wróć</a>)</p>
    </div>
    <div id="lotterybox" class="dottedBox pageFont">
            <?php include 'pages/lotteryBox.html.php'; ?>
    </div>
    <div id="userlistbox" class="dottedBox pageFont">
        <h1>Użytkownicy</h1>
        <div id="usertable">
            <?php include 'pages/userTable.html.php'; ?>
        </div>
        <p><a class="pageFont" href="javascript:void(0);" onclick="addUserClick()"><img src="pages/images/add.png" alt="add" title="Dodaj użytkownika">Dodaj użytkownika</a></p>
    </div>
</div>
<div id="dialog-addUser" class="dialog" title="Dodawanie użytkownika">
    <form id="addUserForm">
        <table>
            <td><label for="new_level">Uprawienia</label></td>
            <td>
                <select id="new_level" name="new_level">
                    <option value="3">Dzieciak</option>
                    <option value="2">Dorosły</option>
                    <option value="1">Św. Mikołaj</option>
                </select>
            </td>
            <tr>
                <td><label for="new_login">Login</label></td>
                <td><input id="new_login" name="new_login" type="text" size="15"/></td>
            </tr>
            <tr>
                <td><label for="new_password">Hasło</label></td>
                <td><input id="new_password" name="new_password" type="password" size="15"/></td>
            </tr>
            <tr>
                <td><label for="new_name">Imię</label></td>
                <td><input id="new_name" name="new_name" type="text" size="15"/></td>
            </tr>
            <tr>
                <td><label for="new_surname">Nazwisko</label></td>
                <td><input id="new_surname" name="new_surname" type="text" size="15"/></td>
            </tr>
            <tr>
                <td><label for="new_lottery">Loteria</label></td>
                <td><input id="new_lottery" name="new_lottery" type="checkbox" value="1"/></td>
            </tr>
        </table>
    </form>
</div>
<div id="dialog-addUserAck" class="dialog" title="Dodawanie użytkownika">
    <p>Użytkownik został dodany</p>
</div>
<div id="dialog-delUser" class="dialog" title="Usuwanie użytkownika">
    <p>Czy na pewno chcesz usunąć użytkownika?</p>
</div>
<div id="dialog-delUserAck" class="dialog" title="Usuwanie użytkownika">
    <p>Użytkownik został usunięty</p>
</div>
<div id="dialog-startLottery" class="dialog" title="Losowanie">
    <p>Czy na pewno chcesz uruchomić losowanie?</p>
</div>
<div id="dialog-startLotteryAck" class="dialog" title="Losowanie">
    <p>Losowanie została uruchomiona</p>
</div>
<div id="dialog-stopLottery" class="dialog" title="Losowanie">
    <p>Czy na pewno chcesz zatrzymać losowanie?</p>
</div>
<div id="dialog-stopLotteryAck" class="dialog" title="Losowanie">
    <p>Losowanie zostało zatrzymana</p>
</div>
<script type="text/javascript" src="pages/scripts/md5.js"></script>
<script>
    $("#dialog-addUser").dialog({
            resizable: false,
            modal: true,
            autoOpen: false,
            buttons: {
                "Ok": function() {
                        addUser();
                        $( this ).dialog("close");
                }
            },
            close: function() {
                $('#addUserForm')[0].reset();
                $( this ).dialog("close");
            }
    });
    $("#dialog-addUserAck").dialog({
            resizable: false,
            modal: true,
            autoOpen: false,
            buttons: {
                "Ok": function() {
                    $( this ).dialog("close");
                }
            },
            close: function() {
                $( this ).dialog("close");
            }
    });
    function addUserClick() {
        $("#dialog-addUser").dialog("open");
    }
    function addUser() {
        var passhash = CryptoJS.MD5($('#new_password').val());
        if(!$('#new_lottery').is(':checked')) {
          $('#new_lottery').val(0);
        }
        $.post("index.php?admin&a=addUser", {
            login: $('#new_login').val(),
            password: encodeURIComponent(passhash),
            name: $('#new_name').val(),
            surname: $('#new_surname').val(),
            level: $('#new_level').val(),
            lottery: $('#new_lottery').val(),
        },
        function(data) {
            var errorcontent = $('#errorcontent', $.parseHTML(data));
            if (typeof(errorcontent.html()) === 'undefined') {
               $('#usertable').load('index.php?admin&a=userTable');
               $("#dialog-addUserAck").dialog("open");
            } else {
                document.write(data);
            }
        });
    }
    $("#dialog-delUserAck").dialog({
            resizable: false,
            modal: true,
            autoOpen: false,
            buttons: {
                "Ok": function() {
                    $( this ).dialog("close");
                }
            },
            close: function() {
                $( this ).dialog("close");
            }
    });
    function delUserClick(username) {
        $("#dialog-delUser").dialog({
            resizable: false,
            modal: true,
            autoOpen: true,
            buttons: {
                "Tak": function() {
                    delUser(username);
                    $( this ).dialog("close");
                },
                "Anuluj": function() {
                    $( this ).dialog("close");
                }
            }
        });
    }
    function delUser(username) {
        $.get("index.php?admin&a=delUser&user="+encodeURIComponent(username), function( data ) {
            var errorcontent = $('#errorcontent', $.parseHTML(data));
            if (typeof(errorcontent.html()) === 'undefined') {
                $('#usertable').load('index.php?admin&a=userTable');
                $("#dialog-delUserAck").dialog("open");
            } else {
                document.write(data);
            }
        });
    }
    function startLotteryClick() {
        $("#dialog-startLottery").dialog({
            resizable: false,
            modal: true,
            autoOpen: true,
            buttons: {
                "Tak": function() {
                    startLottery();
                    $( this ).dialog("close");
                },
                "Anuluj": function() {
                    $( this ).dialog("close");
                }
            }
        });
    }
    function startLottery() {
        $.get("index.php?lottery&a=start", function( data ) {
            var errorcontent = $('#errorcontent', $.parseHTML(data));
            if (typeof(errorcontent.html()) === 'undefined') {
                $('#lotterybox').load('index.php?admin&a=lotteryBox');
                $("#dialog-startLotteryAck").dialog({
                        resizable: false,
                        modal: true,
                        autoOpen: true,
                        buttons: {
                            "Ok": function() {
                                $( this ).dialog("close");
                            }
                        },
                        close: function() {
                            $( this ).dialog("close");
                        }
                });
            } else {
                document.write(data);
            }
        });
    }
    function stopLotteryClick() {
        $("#dialog-stopLottery").dialog({
            resizable: false,
            modal: true,
            autoOpen: true,
            buttons: {
                "Tak": function() {
                    stopLottery();
                    $( this ).dialog("close");
                },
                "Anuluj": function() {
                    $( this ).dialog("close");
                }
            }
        });
    }
    function stopLottery() {
        $.get("index.php?lottery&a=stop", function( data ) {
            var errorcontent = $('#errorcontent', $.parseHTML(data));
            if (typeof(errorcontent.html()) === 'undefined') {
                $('#lotterybox').load('index.php?admin&a=lotteryBox');
                $("#dialog-stopLotteryAck").dialog({
                        resizable: false,
                        modal: true,
                        autoOpen: true,
                        buttons: {
                            "Ok": function() {
                                $( this ).dialog("close");
                            }
                        },
                        close: function() {
                            $( this ).dialog("close");
                        }
                });
            } else {
                document.write(data);
            }
        });
    }
</script>
<?php include 'pages/footer.html.php'; ?>
