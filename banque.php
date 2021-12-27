<?php
    $mt= 0 ;

    if(isset($_POST['action'])){

        $action = $_POST['action'];

        if($action == "OK"){

            if(isset($_POST['montant'])){

                $mt = $_POST['montant'];
                $clientSOAP = new SoapClient("http://localhost:8586/BanqueService?wsdl");
                $param = new stdClass();
                $param->montant=$mt;
                $res =  $clientSOAP->__soapCall("ConversionEuroToDt",array($param));
            }
        }elseif($action == "ShowComptes"){

            $clientSOAP = new SoapClient("http://localhost:8586/BanqueService?wsdl");
            $cptes = $clientSOAP->__soapCall("getComptes",array());
        }
    }
?>

<html>
    <body>
        <form action="banque.php" method="POST">
            <label for="Montant">Montant</label>
            <input type="text" name="montant" value="<?php echo($mt) ?>" >
            <input name="action" type="submit" value="OK">

            <input name="action" type="submit" value="ShowComptes">
        </form>

        <?php if(isset($res)){ ?>

            <?php
                echo($mt)
            ?> En euro = <?php echo($res->return) ?> En Dt 

        <?php } ?>


        <?php if(isset($cptes)){ ?>

            <table border="1">
                <tr>
                    <th>Code</th>
                    <th>Solde</th>
                </tr>

                <?php foreach ($cptes->return as $com) {?>
                    <tr>
                        <td><?php echo($com->code) ?></td>
                        <td><?php echo($com->solde) ?></td>
                    </tr>
                <?php } ?>
            </table>

        <?php } ?>
        
    </body>
</html>