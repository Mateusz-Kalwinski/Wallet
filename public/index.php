<?php

require_once '../sys/class/Expenses.php';
require_once '../sys/class/User.php';


$pageTitle = "Wallet - Finanse pod kontrolą";
$css_files = array('style.css');

require_once 'assets/common/navbar.php';

$expenses = new Expenses();
$user = new User();

?>

<div class="container-fluid menu-space">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <table class="custom-table table">
                <thead>
                <tr>
                    <th class="nameTypo" scope="col">Nazwa</th>
                    <th class="categoryTypo" scope="col">Kategoria</th>
                    <th class="priceTypo" scope="col">Cena</th>
                    <th class="dateTypo" scope="col">Data</th>
                </tr>
                </thead>
                <tbody>

                <?php

                    $dataExpenses = $expenses->lastExpenses(5);

                    foreach ($dataExpenses as $dataExpens){
                        echo'
                            <tr>
                            <td class="nameTypo">'.$dataExpens['expense_name'].'</td>
                            <td class="categoryTypo">'.$dataExpens['category_name'].'</td>
                            <td class="priceTypo">'.$dataExpens['expense_price'].' zł</td>
                            <td class="dateTypo">'.$dataExpens['expense_date'].'</td>
                            </tr>';
                        }
                ?>

                </tbody>
            </table>
        </div>
        <?php
            $userData = $user->userData(1);
            $sumExpenses = $expenses->allExpensesMonth();

        ?>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <h1 class="text-purple text-center">twój budżet:</h1>
            <h4 class="text-grey text-center"><?=$userData[0]['budget']?> zł</h4>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <h1 class="text-purple text-center">W tym miesiącu wydałeś:</h1>
            <h4 class="text-grey text-center"><?=$sumExpenses?> zł</h4>
        </div>
</div>

<?php
    require_once 'assets/common/footer.php'
?>


