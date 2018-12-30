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

$userId = $_SESSION['id'];

require_once '../sys/class/Expenses.php';
require_once '../sys/class/User.php';
require_once '../sys/class/Category.php';


$pageTitle = "Wallet - Finanse pod kontrolą";
$css_files = array('style.css');

require_once 'assets/common/navbar-admin.php';

$expenses = new Expenses();
$user = new User();
$category = new Category();


?>

<div class="container-fluid menu-space ">
    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-12 mx-auto">
            <table class="custom-table table">
                <thead>
                <tr>
                    <th class="nameTypo text-left" scope="col">Nazwa</th>
                    <th class="categoryTypo text-left" scope="col">Kategoria</th>
                    <th class="priceTypo text-left" scope="col">Cena</th>
                    <th class="dateTypo text-left" scope="col">Data</th>
                    <th class="editTypo" scope="col">Edytuj</th>
                    <th class="deleteTypo" scope="col">Usuń</th>
                </tr>
                </thead>
                <tbody>

                <?php

                $dataExpenses = $expenses->getAllExpenses($userId);

                foreach ($dataExpenses as $dataExpens){
                    echo'
                            <tr style="transition: all 1s ease">
                            <td class="idExpense d-none" id="'.$dataExpens['id'].'">'.$dataExpens['id'].'</td>
                            <td class="nameTypo">'.$dataExpens['expense_name'].'</td>
                            <td class="categoryTypo">'.$dataExpens['category_name'].'</td>
                            <td class="priceTypo">'.$dataExpens['expense_price'].' zł</td>
                            <td class="dateTypo">'.$dataExpens['expense_date'].'</td>
                            <td class="text-center"><a class="nav-link js-scroll-trigger link-hover getvalue" href="#" data-toggle="modal" data-target="#editExpense"><img src="assets/img/baseline-edit-24px.svg" alt="edit icon"></a></td>
                            <td class="text-center">
                                <form id="deleteExpense" method="post" action="ajax/deleteExpense.php" class="nav-link js-scroll-trigger link-hover getvalue">
                                    <div class="form-group d-none">
                                        <label for="expenseId">ID</label>
                                        <input type="text" name="expenseId" class="form-control" id="expenseId" value="'.$dataExpens['id'].'">
                                    </div>
                                    
                                    <button type="submit" class="delete-btn"></button>
                                
                                </form>
                            </td>
                            </tr>';
                }
                ?>

                </tbody>
            </table>
        </div>

        <script>
            $(".getvalue").click(function(){

                var expenseId = ($(this).parent().parent().find('.idExpense').text());
                var name = ($(this).parent().parent().find('.nameTypo').text());

                var priceText = ($(this).parent().parent().find('.priceTypo').text());
                var priveVal = priceText.substr(0, priceText.length-3);


                var dateText = ($(this).parent().parent().find('.dateTypo').text());
                var dateVal = dateText.substr(0, dateText.length-9);
                var timeVal = dateText.substr(11, dateText.length-9);


                var modalId = $('.modal').find('#expenseId').val(expenseId);
                var modalName = $('.modal').find('#expenseName').val(name);
                var modalPrice = $('.modal').find('#expensePrice').val(priveVal);
                var modalDate = $('.modal').find('#expenseDate').val(dateVal);
                var modalTime = $('.modal').find('#expenseTime').val(timeVal);



            });
        </script>

<!--EDIT MODAL-->
        <div class="modal fade" id="editExpense" tabindex="-1" role="dialog" aria-labelledby="editExpense" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-purple" id="addExpenseLabel">Edytuj wydatek wydatek</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form action="ajax/editExpense.php" method="post" id="editExpenseForm">

                            <div class="form-group d-none">
                                <label for="expenseId">ID</label>
                                <input type="text" name="expenseId" class="form-control" id="expenseId" value="">
                            </div>

                            <div class="form-group">
                                <label for="expenseName">Nazwa</label>
                                <input type="text" name="expenseName" class="form-control" id="expenseName" aria-describedby="info" placeholder="Nazwa wydatku">
                                <small id="info" class="form-text text-muted">Pole niewymagane</small>
                            </div>

                            <div class="form-group">
                                <label for="expenseCategory">Kategoria</label>
                                <select name="expenseCategory" class="form-control" id="expenseCategory">
                                    <?php

                                    $dataCategories = $category->categoryData($userId);

                                    foreach ($dataCategories as $dataCategory){
                                        echo '<option value='. $dataCategory['id'].'>'.$dataCategory["category_name"].'</option>';
                                    }

                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="expensePrice">Kwota</label>
                                <input type="number" step="0.01" name="expensePrice" class="form-control" id="expensePrice" placeholder="Kwota wydatku np: 7.27" value="">
                            </div>

                            <div class="form-group">
                                <label for="expenseDate">Data</label>

                                <input type="date" name="expenseDate" id="expenseDate" class="form-control" value="">
                            </div>

                            <div class="form-group d-none">
                                <label for="expenseTime">Czas</label>

                                <input type="text" name="expenseTime" id="expenseTime" class="form-control" value="">
                            </div>

                            <button type="submit" class="btn btn-primary">Edytuj</button>

                            <h4 class="text-purple" id="edit-results-expense"></h4>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <script>

            $("#deleteExpense").submit(function(event){
                event.preventDefault();
                var post_url = $(this).attr("action");
                var request_method = $(this).attr("method");
                var form_data = $(this).serialize();

                $.ajax({
                    url : post_url,
                    type: request_method,
                    data : form_data
                }).done(function(data){
                    var parseData = JSON.parse(data);
                     var parseID = parseData['id'];

                    $( "#" + parseID ).parent().css({"transition" : "all 1s easy",
                        "background-color" : '#d5cdf5'
                    });

                    setTimeout(function(){
                        $( "#" + parseID ).parent().remove();
                    },1000);

                });
            });


            $("#editExpenseForm").submit(function(event){
                event.preventDefault();
                var post_url = $(this).attr("action");
                var request_method = $(this).attr("method");
                var form_data = $(this).serialize();

                $.ajax({
                    url : post_url,
                    type: request_method,
                    data : form_data
                }).done(function(data){
                    var selected = $('#expenseCategory').find(":selected").text();

                    var parseData = JSON.parse(data);
                    var parseID = parseData['id'];

                    $( "#" + parseID ).parent().css({"transition" : "all 1s easy",
                        "background-color" : '#d5cdf5'
                    });

                    setTimeout(function(){
                        $( "#" + parseID ).parent().css({"transition" : "all 1s easy",
                            "background-color" : 'white'
                        });
                    },2000);

                    $( "#" + parseID ).next().text(parseData['name']);

                    $( "#" + parseID ).next().next().text(selected);

                    $( "#" + parseID ).next().next().next().text(parseData['price'] + ' zł');

                    $( "#" + parseID ).next().next().next().next().text(parseData['date']);

                    $("#edit-results-expense").html(parseData['msg']);



                });
            });

        </script>
