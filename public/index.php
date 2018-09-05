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
            $sumExpenses_0 = $expenses->allExpensesMonth(0);
            $sumExpenses_1 = $expenses->allExpensesMonth(1);
            $sumExpenses_2 = $expenses->allExpensesMonth(2);
            $sumExpenses_3 = $expenses->allExpensesMonth(3);
            $sumExpenses_4 = $expenses->allExpensesMonth(4);

            $dataLabel = date('n');

        ?>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <h1 class="text-purple text-center">twój budżet:</h1>
            <h4 class="text-grey text-center"><?=$userData[0]['budget']?> zł</h4>
            <br>
            <canvas id="myChart" style="width: 200px; height: 200px;" width="1300" height="340"></canvas>


        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <h1 class="text-purple text-center">W tym miesiącu wydałeś:</h1>
            <h4 class="text-grey text-center"><?=$sumExpenses_0?> zł</h4>
            <br>
            <canvas id="myChart1" style="width: 200px; height: 200px;" width="1300" height="340"></canvas>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

<script>
    var ctx = document.getElementById("myChart").getContext('2d');


    var gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
    gradientStroke.addColorStop(0.4, '#8445ff');
    gradientStroke.addColorStop(1, '#369fff');

    var gradientStroke1 = ctx.createLinearGradient(500, 0, 100, 0);
    gradientStroke1.addColorStop(0.35, '#00cef2');
    gradientStroke1.addColorStop(0.6, '#54fbb5');


    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Twój budżet", "Początkowy budżet"],
            datasets: [{
                label: '# of Votes',
                data: [<?=$userData[0]['budget']?>, <?=$userData[0]['budget_start']?>],
                backgroundColor: [
                    gradientStroke1,
                    gradientStroke,
                ],
                borderColor: [
                    'rgba(132, 69, 255, 1)',
                    'rgba(54, 159, 255, 1)',
                ],
                borderWidth: 0
            }]
        },
        options: {
            legend: {
                display: false
            }
        }
    });

    var ctx = document.getElementById("myChart1").getContext('2d');


    var gradientStroke = ctx.createLinearGradient(500, 430, 0, 0);
    gradientStroke.addColorStop(0.4, '#8445ff');
    gradientStroke.addColorStop(0.7, '#369fff');

    var gradientStroke1 = ctx.createLinearGradient(500, 0, 100, 0);
    gradientStroke1.addColorStop(0.35, '#00cef2');
    gradientStroke1.addColorStop(0.6, '#54fbb5');

    var gradientStroke2 = ctx.createLinearGradient(500, 0, 100, 0);
    gradientStroke2.addColorStop(0.35, '#f9e86f');
    gradientStroke2.addColorStop(0.6, '#f1688d');

    var gradientStroke3 = ctx.createLinearGradient(500, 430, 0, 0);
    gradientStroke3.addColorStop(0.55, '#27f9c6');
    gradientStroke3.addColorStop(0.7, '#44acf1');

    var gradientStroke4 = ctx.createLinearGradient(500, 0, 100, 0);
    gradientStroke4.addColorStop(0.55, '#f97ca2');
    gradientStroke4.addColorStop(0.7, '#c185f1');

    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["<?=$dataLabel?>", "<?=$dataLabel -1?>", "<?=$dataLabel -2?>", "<?=$dataLabel -3?>", "<?=$dataLabel -4?>"],
            datasets: [{
                label: '# of Votes',
                data: [<?=$sumExpenses_0?>, <?=$sumExpenses_1?>, <?=$sumExpenses_2?>, <?=$sumExpenses_3?>, <?=$sumExpenses_4?>],
                backgroundColor: [
                    gradientStroke1,
                    gradientStroke,
                    gradientStroke2,
                    gradientStroke3,
                    gradientStroke4,

                ],
                borderColor: [
                    'rgba(132, 69, 255, 1)',
                    'rgba(54, 159, 255, 1)',
                ],
                borderWidth: 0
            }]
        },
        options: {
            legend: {
                display: false
            }
        }
    });
</script>

<?php
    require_once 'assets/common/footer.php'
?>


