<?php
session_name('user');
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.gc_maxlifetime', 259200);
session_set_cookie_params(259200);
session_start();

if (empty($_SESSION)){
    header('Location: login.php');
}

require_once '../sys/class/Expenses.php';
require_once '../sys/class/User.php';
require_once '../sys/class/Category.php';


$pageTitle = "Wallet - Finanse pod kontrolą";
$css_files = array('style.css');

require_once 'assets/common/navbar.php';

$expenses = new Expenses();
$user = new User();
$category = new Category();

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
            if (empty($expenses->allExpensesMonth(0)) OR empty($expenses->allExpensesMonth(1)) OR empty($expenses->allExpensesMonth(2)) OR empty($expenses->allExpensesMonth(3)) OR empty($expenses->allExpensesMonth(4))){
                $sumExpenses_0 = 0;
                $sumExpenses_1 = 0;
                $sumExpenses_2 = 0;
                $sumExpenses_3 = 0;
                $sumExpenses_4 = 0;
            }else {
                $sumExpenses_0 = $expenses->allExpensesMonth(0);
                $sumExpenses_1 = $expenses->allExpensesMonth(1);
                $sumExpenses_2 = $expenses->allExpensesMonth(2);
                $sumExpenses_3 = $expenses->allExpensesMonth(3);
                $sumExpenses_4 = $expenses->allExpensesMonth(4);
            }

            $dataLabel = date('n');

        ?>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <h2 class="text-purple text-center">twój budżet:</h2>
            <h4 class="text-grey text-center"><?=$userData[0]['budget_start'] - $sumExpenses_0?> zł</h4>
            <br>
            <canvas id="myChart" style="width: 200px; height: 200px;" width="1300" height="340"></canvas>


        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <h2 class="text-purple text-center">W tym miesiącu wydałeś:</h2>
            <h4 class="text-grey text-center"><?=$sumExpenses_0?> zł</h4>
            <br>
            <canvas id="myChart1" style="width: 200px; height: 200px;" width="1300" height="340"></canvas>
        </div>
    </div>

    <!-- MODAL ADD EXPENSE   -->
    <div class="modal fade" id="addExpense" tabindex="-1" role="dialog" aria-labelledby="addExpenseLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-purple" id="addExpenseLabel">Dodaj wydatek</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="ajax/addExpense.php" method="post" id="addExpenseForm">
                        <div class="form-group">
                            <label for="expenseName">Nazwa</label>
                            <input type="text" name="expenseName" class="form-control" id="expenseName" aria-describedby="info" placeholder="Nazwa wydatku">
                            <small id="info" class="form-text text-muted">Pole niewymagane</small>
                        </div>
                        <div class="form-group">
                            <label for="expenseCategory">Kategoria</label>
                            <select name="expenseCategory" class="form-control" id="expenseCategory">
                                <?php

                                $dataCategories = $category->categoryData();

                                foreach ($dataCategories as $dataCategory){
                                    echo '<option value='. $dataCategory['id'].'>'.$dataCategory["category_name"].'</option>';
                                }

                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="expensePrice">Kwota</label>
                            <input type="number" name="expensePrice" class="form-control" id="expensePrice" placeholder="Kwota wydatku np: 7.27">
                        </div>
                        <div class="form-group">
                            <label for="expenseDate">Data</label>

                            <input type="date" name="expenseDate" id="expenseDate" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary text-purple">Dodaj</button>

                        <h4 class="text-purple" id="server-results-expense"></h4>
                    </form>
                </div>

            </div>
        </div>
    </div>

<!-- MODAL ADD CATEGORY   -->

    <div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="addCategoryLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-purple" id="addCategoryLabel">Dodaj kategorie</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="ajax/addCategory.php" method="post" id="addCategoryForm">
                        <div class="form-group">
                            <label for="categoryName">Nazwa</label>
                            <input type="text" name="categoryName" class="form-control" id="categoryName" aria-describedby="info" placeholder="Nazwa kategorii">
                        </div>
                        <button type="submit" class="btn btn-primary text-purple">Dodaj</button>

                        <h4 class="text-purple" id="server-results-category"></h4>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- MODAL ADD ACCOUNT   -->

<div class="modal fade " id="account" tabindex="-1" role="dialog" aria-labelledby="accountLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-purple" id="accountLabel">Moje konto</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="col-lg-6 col-md-6 col-sm-12 p-3">
                        <p class="d-inline text-grey">Nazwa użytkownika:</p>
                        <p class="d-inline text-grey"><?=$userData[0]['name']?></p>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 p-3">
                        <p class="d-inline text-grey">Email: </p>
                        <p class="d-inline text-grey"><?=$userData[0]['email']?></p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 p-3">
                        <p class="d-inline text-grey">Ogólny budżet: </p>
                        <p class="d-inline text-grey"><?=$userData[0]['budget_start']?></p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 p-3">
                        <p class="d-inline text-grey">Twój budżet: </p>
                        <p class="d-inline text-grey"><?=$userData[0]['budget_start'] - $sumExpenses_0?></p>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 p-3">
                        <h5 class="text-purple" id="accountLabel">Formularz dodawania budżetu początkowego.</h5>
                        <form action="ajax/updateOverallBudget.php" method="post" id="updateOverallBudget">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="addToBudget" id="addToBudget" value="addToBudget" checked>
                                <label class="form-check-label" for="addToBudget">Dodaj kwote do budżetu</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="overwriteBudget" id="overwriteBudget" value="overwriteBudget">
                                <label class="form-check-label" for="overwriteBudget">Nadpisz budżet</label>
                            </div>
                            <div class="form-group">
                                <input type="number" name="OverallBudget" class="form-control" id="OverallBudget" aria-describedby="infoBudget" placeholder="Podaj kwote" step="0.01">
                                <small id="infoBudget" class="form-text text-muted">Po zatwierdzeniu budżet ogólny zostanie nadpisany.</small>
                            </div>
                            <button type="submit" class="btn btn-primary text-purple">Dodaj</button>

                            <h4 class="text-purple" id="server-results-budget"></h4>
                        </form>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 p-3">
                        <h5 class="text-purple">Formularz zmiany hasła.</h5>
                        <form action="ajax/resetPassword.php" method="post" id="resetPassword">
                            <div class="form-group">
                                <label for="emailAddress">Adres email</label>
                                <input type="email" name="emailAddress" class="form-control" id="emailAddress"  placeholder="Twój adres email.">
                            </div>
                            <div class="form-group">
                                <label for="curentPassword">Aktualne hasło</label>
                                <input type="password" name="curentPassword" class="form-control" id="curentPassword"  placeholder="Twoje aktualne hasło.">
                            </div>
                            <div class="form-group">
                                <label for="newPassword">Nowe Hasło</label>
                                <input type="password" name="newPassword" class="form-control" id="newPassword"  placeholder="Podaj nowe hasło">
                            </div>
                            <button type="submit" class="btn btn-primary text-purple">Zmień hasło</button>

                            <h4 class="text-purple" id="server-results-resetPassword"></h4>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

<script>
//    AJAX


$("#addExpenseForm").submit(function(event){
    event.preventDefault();
    var post_url = $(this).attr("action");
    var request_method = $(this).attr("method");
    var form_data = $(this).serialize();

    $.ajax({
        url : post_url,
        type: request_method,
        data : form_data
    }).done(function(response){
        $("#server-results-expense").html(response);

    });
});

$("#addCategoryForm").submit(function(event){
    event.preventDefault();
    var post_url = $(this).attr("action");
    var request_method = $(this).attr("method");
    var form_data = $(this).serialize();

    $.ajax({
        url : post_url,
        type: request_method,
        data : form_data
    }).done(function(response){
        $("#server-results-category").html(response);

    });
});

$("#updateOverallBudget").submit(function(event){
    event.preventDefault();
    var post_url = $(this).attr("action");
    var request_method = $(this).attr("method");
    var form_data = $(this).serialize();

    $.ajax({
        url : post_url,
        type: request_method,
        data : form_data
    }).done(function(response){
        $("#server-results-budget").html(response);

    });
});

$("#resetPassword").submit(function(event){
    event.preventDefault();
    var post_url = $(this).attr("action");
    var request_method = $(this).attr("method");
    var form_data = $(this).serialize();

    $.ajax({
        url : post_url,
        type: request_method,
        data : form_data
    }).done(function(response){
        $("#server-results-resetPassword").html(response);

    });
});

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
            labels: ["Twój budżet", "Całościowy budżet"],
            datasets: [{
                label: '# of Votes',
                data: [<?=$userData[0]['budget_start'] - $sumExpenses_0?>, <?=$userData[0]['budget_start']?>],
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
                    gradientStroke,
                    gradientStroke1,
                    gradientStroke2,
                    gradientStroke3,
                    gradientStroke4,
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


