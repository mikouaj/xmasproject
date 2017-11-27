<?php include 'pages/header.html.php'; ?>
<?php $exception = $this->get('exception'); ?>
<div id="errorcontent" class="pageFont">
    <p>Przepraszamy, strona wygenerowała błąd :-(</p>
    <p>Plik <?php print($exception->getFile());?> linia <?php print($exception->getLine());?></p>
    <p><?php print($exception->getMessage());?></p>
    <p><?php print($exception->getTraceAsString());?></p>
</div>
<?php include 'pages/footer.html.php'; ?>