<?php include 'pages/header.html.php'; ?>
<div id="pagecontent" class="pageFont">
    <div id="logincontent">
        <p>Witaj! Zaloguj się aby zacząc zabawę!</p>
        <?php
        if($this->loginFault==true) {
            ?> <p class="error">Zły użytkownik lub hasło, spróbuj ponownie!</p> <?php   
        }
        ?>
        <form method="post" action="index.php?login">
        <table class="pageFont">
            <tr>
                <td><label>Imię</label></td>
                <td><input type="text" maxlength="18" name="username" size="20"></td>
            <tr>
                <td><label>Hasło</label></td>
                <td>
                    <input type="password" maxlength="18" name="password" size="20">
                    <input type="hidden" name="requestedUrl" value="<?php print($this->get('requestedUrl'));?>" >
                </td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Zaloguj"></td>
            </tr>
        </table>
        </form>
    </div>
</div>
<?php include 'pages/footer.html.php'; ?>