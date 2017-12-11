<?php include 'pages/header.html.php'; ?>
<?php
    $title = $this->get('title');
?>
<div id="pagecontent" class="pageFont">
    <div id="navpath">
        <p>Jesteś w panelu prezentów (<a href="index.php?xmas" class="pageFont">Wróć</a>)</p>
    </div>
    <div id="presentslistbox" class="dottedBox pageFont">
        <h1><?php print($title);?></h1>
        <div id="presentsTable" class='myTable'>
            <?php include 'pages/presentsTable.html.php'; ?>
        </div>
        <?php if($isEditable) { ?>
        <p><a class="pageFont" href="javascript:void(0);" onclick="addPresentClick()"><img src="pages/images/add.png" alt="add" title="Dodaj użytkownika">Dodaj prezent</a></p>
        <?php } ?>
    </div>
</div>
<div id="dialog-addPresent" class="dialog" title="Dodawanie prezentu">
    <form id="addPresentForm">
        <table>
            <tr>
                <td><label for="new_name">Nazwa*</label></td>
                <td><input id="new_name" name="new_name" type="text" size="20"/></td>
            </tr>
            <tr>
                <td><label for="new_desc">Opis*</label></td>
                <td><input id="new_desc" name="new_desc" type="text" size="30"/></td>
            </tr>
            <tr>
                <td><label for="new_link">Link</label></td>
                <td><input id="new_link" name="new_link" type="text" size="30"/></td>
            </tr>
        </table>
    </form>
</div>
<div id="dialog-addPresentAck" class="dialog" title="Dodawanie prezentu">
    <p>Prezent został dodany</p>
</div>
<div id="dialog-delPresent" class="dialog" title="Usuwanie prezentu">
    <p>Czy na pewno chcesz usunąć prezent?</p>
</div>
<div id="dialog-delPresentAck" class="dialog" title="Usuwanie prezentu">
    <p>Prezent został usunięty</p>
</div>
<div id="dialog-reservePresentAck" class="dialog" title="Rezerwacja prezentu">
    <p>Rezerwacja prezentu została zaktualizowana</p>
</div>
<script>
    function addPresentClick() {
        $("#dialog-addPresent").dialog({
                resizable: false,
                modal: true,
                autoOpen: true,
                buttons: {
                    "Ok": function() {
                            addPresent();
                            $( this ).dialog("close");
                    }
                },
                close: function() {
                    $('#addPresentForm')[0].reset();
                    $( this ).dialog("close");
                }
        });
    }
    function addPresent() {
        $.post("index.php?presents&a=add", {
            name: $('#new_name').val(),
            desc: $('#new_desc').val(),
            link: $('#new_link').val(),
        },
        function(data) {
            var errorcontent = $('#errorcontent', $.parseHTML(data));
            if (typeof(errorcontent.html()) === 'undefined') {
               $('#presentsTable').load('index.php?presents&table');
                $("#dialog-addPresentAck").dialog({
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
    function delPresentClick(id) {
        $("#dialog-delPresent").dialog({
                resizable: false,
                modal: true,
                autoOpen: true,
                buttons: {
                    "Ok": function() {
                        delPresent(id);
                        $( this ).dialog("close");
                    },
                    "Anuluj": function() {
                        $( this ).dialog("close");
                    }
                }
        });
    }
    function delPresent(id) {
        $.get("index.php?presents&a=delete&id="+encodeURIComponent(id), function( data ) {
            var errorcontent = $('#errorcontent', $.parseHTML(data));
            if (typeof(errorcontent.html()) === 'undefined') {
                $('#presentsTable').load('index.php?presents&table');
                $("#dialog-delPresentAck").dialog({
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
    function toggleReservationClick(id) {
        $.get("index.php?presents&a=togglereservation&id="+encodeURIComponent(id), function( data ) {
            var errorcontent = $('#errorcontent', $.parseHTML(data));
            if (typeof(errorcontent.html()) === 'undefined') {
                $("#dialog-reservePresentAck").dialog({
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
