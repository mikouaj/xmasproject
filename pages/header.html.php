<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>Merry Christmas 2017</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="icon" type="image/vnd.microsoft.icon" href="pages/images/favicon.ico">
        <link rel="stylesheet" href="pages/styles/page.css" type="text/css">
        <link rel="stylesheet" href="pages/styles/jquery-ui.min.css" type="text/css">
        <script type="text/javascript" src="pages/scripts/external/jquery/jquery.js"></script>
        <script type="text/javascript" src="pages/scripts/jquery-ui.min.js"></script>
        <script type="text/javascript" src="pages/scripts/jquery.validate.min.js"></script>
    </head>
    <body>
        <div id="page">
            <div id="topbar">&nbsp;</div>
            <div id="leftbar" class="left">&nbsp;</div>
            <div id="rightbar" class="right">&nbsp;</div>
            <div class="center">
                <div id="title">
                    <img src="pages/images/gold_present_100.png" alt="Present"/>
                    <img src="pages/images/xmas_generic_text_500.png" alt="Marry Christmas"/>
                </div>
                <div id="header">
                    <div class="left">
                        <p class="pageFont">Do Wigilii zostało
                        <script type="text/javascript">
                            TargetDate = "12/24/2017 5:00 PM";
                            BackColor = "white";
                            ForeColor = "black";
                            CountActive = true;
                            CountStepper = -1;
                            LeadingZero = true;
                            DisplayFormat = "%%D%% dni, %%H%% godzin, %%M%% minut, %%S%% sekund.";
                            FinishMessage = " - czas Wigilii juz nadszedl!";
                        </script>
                        <script src="pages/scripts/countdown.js" type="text/javascript"></script>
                        </p>
                    </div>
                    <?php
                    $userModel=$this->loadModel('user');
                    if($userModel->isLoggedin()) {
                    ?>
                    <div class="right">
                        <p class="pageFont">Witaj <?php print($userModel->getUserName());?> <span style="font-size:smaller">(<a href="index.php?login&a=logout">wyloguj</a>)</span></p>
                    </div>
                    <?php } ?>
                    <div class="spacer"></div>
                </div>
