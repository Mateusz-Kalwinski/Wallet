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
                    <th class="categoryTypo" scope="col">Kolor</th>
                    <th class="editTypo" scope="col">Edytuj</th>
                    <th class="deleteTypo" scope="col">Usuń</th>
                </tr>
                </thead>
                <tbody>

                <?php

                $dataCategories = $category->categoryData($userId);

                foreach ($dataCategories as $dataCategory){
                    echo'
                            <tr style="transition: all 1s ease">
                            <td class="idCategory d-none" id="'.$dataCategory['id'].'">'.$dataCategory['id'].'</td>
                            <td class="nameTypo">'.$dataCategory['category_name'].'</td>
                            <td class="categoryTypo" style="background-color: '.$dataCategory['category_color'].'; color: '.$dataCategory['category_color'].';">'.$dataCategory['category_color'].'</td>
                          
                          
                          
                            <td class="text-center"><a class="nav-link js-scroll-trigger link-hover getvalue" href="#" data-toggle="modal" data-target="#editCategory"><img src="assets/img/baseline-edit-24px.svg" alt="edit icon"></a></td>
                            <td class="text-center">
                                <form id="deleteCategory" method="post" action="ajax/deleteCategory.php" class="nav-link js-scroll-trigger link-hover getvalue">
                                    <div class="form-group d-none">
                                        <label for="categoryID">ID</label>
                                        <input type="text" name="categoryID" class="form-control" id="categoryID" value="'.$dataCategory['id'].'">
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
            $(".getvalue").click(function() {
                var categoryId = ($(this).parent().parent().find('.idCategory').text());
                var name = ($(this).parent().parent().find('.nameTypo').text());
                var color = ($(this).parent().parent().find('.categoryTypo').text());

                var modalId = $('.modal').find('#categoryID').val(categoryId);
                var modalName = $('.modal').find('#categoryName').val(name);
                var modalColor = $('.modal').find('#categoryColor').val(color);
            });

        </script>


        <!-- MODAL ADD CATEGORY   -->

        <div class="modal fade" id="editCategory" tabindex="-1" role="dialog" aria-labelledby="addCategoryLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-purple" id="editCategoryLabel">Edytuj kategorie</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form action="ajax/editCategory.php" method="post" id="editCategoryForm">
                            <div class="form-group d-none">
                                <label for="categoryID">ID</label>
                                <input type="text" name="categoryID" class="form-control" id="categoryID" aria-describedby="info" value="">
                            </div>
                            <div class="form-group">
                                <label for="categoryName">Nazwa</label>
                                <input type="text" name="categoryName" class="form-control" id="categoryName" aria-describedby="info" placeholder="Nazwa kategorii">
                            </div>
                            <div class="form-group">
                                <label for="categoryColor">Kolor kategorii</label>
                                <input type="color" name="categoryColor" class="form-control" id="categoryColor" aria-describedby="infoColor" value="#8445ff">
                                <small id="infoColor" class="form-text text-muted">W tym kolorze będą widoczne wydatki na wykresie słupkowym</small>

                            </div>
                            <button type="submit" class="btn btn-primary">Edytuj</button>

                            <h4 class="text-purple" id="edit-results-category"></h4>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>

        $("#deleteCategory").submit(function(event){
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


        $("#editCategoryForm").submit(function(event){
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
                console.log(parseData);

                $( "#" + parseID ).parent().css({"transition" : "all 1s easy",
                    "background-color" : '#d5cdf5'
                });

                setTimeout(function(){
                    $( "#" + parseID ).parent().css({"transition" : "all 1s easy",
                        "background-color" : 'white'
                    });
                },2000);

                $( "#" + parseID ).next().text(parseData['name']);


                $( "#" + parseID ).next().next().css({'background-color': parseData['color'],
                                                      'color' : parseData['color']
                });


                $("#edit-results-category").html(parseData['msg']);



            });
        });

    </script>
