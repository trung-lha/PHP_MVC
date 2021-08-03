?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    </style>
    <link rel="stylesheet" href="http://localhost:8888/PHP_MVC/app/public/CSS/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<body>
    <div class="header">
        <a href="#default" class="logo">Mini Project PHP</a>
        <div class="header-right">
            <a class="active" href="http://localhost:8888/PHP_MVC/logout">Logout</a>
        </div>
    </div>
    <h2>Welcome <?php echo $_SESSION['username'] . " !"; ?></h2>
    <div>
        <div class="form-popup" id="add-form">
            <form class="form-container" method="post" id="add_product">
                <h1>New Product</h1>
                <br>

                <label for="code" style="display:flex"><b>Product code</b></label>
                <input type="text" placeholder="Enter code ..." name="code" id="code_add_form" required>

                <label for="name" style="display:flex"><b>Product name</b></label>
                <input type="text" placeholder="Enter name ..." name="name" id="name_add_form" required>

                <label for="price" style="display:flex"><b>Price</b></label>
                <input type="number" placeholder="Enter price ..." name="price" id="price_add_form" required>

                <label for="quantity" style="display:flex"><b>Quantity</b></label>
                <input type="number" placeholder="Enter quantity" name="quantity" id="quantity_add_form" required>

                <button type="submit" class="btn btn-primary" id="add_button">Submit</button>
                <button type="button" class="btn cancel" onclick="show_hide()">Cancel</button>
            </form>
        </div>
    </div>
    <div class="title_table">
        <h3>Products Table</h3>
        <button class="btn btn-primary" onclick="show_hide()">Add Product</button>
    </div>
    <div id="load_data_ajax">
        <?php
        print_r($product_list);
        ?>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Confirm Delete</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>Are you sure ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="confirm_delete" type="button" class="btn btn-danger">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {

            function fetch_data(event) {
                $.ajax({
                    url: "http://localhost:8888/PHP_MVC/product",
                    success: function(data) {
                        $('#load_data_ajax').html(data);
                    },
                });
            }
            // fetch_data();
            $('#add_button').on('click', function(event) {
                event.preventDefault();
                var code = $('#code_add_form').val();
                var name = $('#name_add_form').val();
                var price = $('#price_add_form').val();
                var quantity = $('#quantity_add_form').val();
                let hasError = false;
                if (name == '' || price == '' || quantity == '' || code == '') {
                    hasError = true
                }
                if (!hasError) {
                    $.ajax({
                        url: "http://localhost:8888/PHP_MVC/san-pham-add",
                        method: "POST",
                        data: {
                            code: code,
                            name: name,
                            price: price,
                            quantity: quantity
                        },
                        success: function(data) {
                            console.log(data);
                            if (data == "1") {
                                alert('Product added successfully!!');
                                $('#add_product')[0].reset();
                                show_hide();
                                fetch_data();
                            } else {
                                event.preventDefault();
                                alert('Product code you have entered is already exits !!');
                            }

                        },
                    });
                }
            });
            //delete data
            $(document).on('click', '.del_data', function() {
                var id = $(this).data('id_del');
                $("#confirm_delete").on('click', function() {
                    $('#confirm_delete').attr('data-dismiss', "modal")
                    $.ajax({
                        url: "http://localhost:8888/PHP_MVC/san-pham-delete",
                        method: "POST",
                        data: {
                            id: id
                        },
                        success: function(data) {
                            $('#alert_notify').alert('close');
                            // alert('Delete product successfully');
                            fetch_data();
                        },
                    });
                })

            });

            //upadate product
            function isDigit(string) {
                var regex = /^[0-9]+$/i;
                var checked = regex.test(string);
                return checked;
            }
            $(document).on('click', '.save_data', function() {
                var id = $(this).data('id_update');
                var currentRow = $(this).closest("tr");
                var code = (currentRow.find("td:eq(0)").text());
                var name = currentRow.find("td:eq(1)").text();
                var price = (currentRow.find("td:eq(2)").text());
                var quantity = (currentRow.find("td:eq(3)").text());

                if (isDigit(price) && isDigit(quantity)) {
                    price = parseInt(price);
                    quantity = parseInt(quantity);
                    $.ajax({
                        url: "http://localhost:8888/PHP_MVC/san-pham-update",
                        method: "POST",
                        data: {
                            id: id,
                            code: code,
                            name: name,
                            price: price,
                            quantity: quantity,
                        },
                        success: function(data) {
                            console.log(data);
                            if (data == "1") {
                                alert('Product information update successfully!!');
                                fetch_data();
                            } else {
                                alert('Product code have to unique !!');
                            }
                        },
                    });
                } else {
                    alert("You entered wrong data");
                }
            });

            // xu ly logic giao dien khi click cac button
            $(document).on('click', '.update_data', function() {
                var id = $(this).data('id_del');
                var id_string = $(this).data('id_string');
                var allProducts = id_string.split('/');
                var newArr = allProducts.splice(0, allProducts.length - 1);
                for (let index = 0; index < newArr.length; index++) {
                    const element = newArr[index];
                    if (id == element) {
                        $("#code_" + id).attr("contenteditable", true);
                        $("#name_" + id).attr("contenteditable", true);
                        $("#price_" + id).attr("contenteditable", true);
                        $("#quantity_" + id).attr("contenteditable", true);
                        $("#code_" + id).css("background-color", "#cbcede");
                        $("#name_" + id).css("background-color", "#cbcede");
                        $("#price_" + id).css("background-color", "#cbcede");
                        $("#quantity_" + id).css("background-color", "#cbcede");
                        $("#action_" + id).css("background-color", "#cbcede");
                        $("#update_" + id).css({
                            "display": "none"
                        });
                        $("#delete_" + id).css({
                            "display": "none"
                        });
                        $("#save_" + id).css({
                            "display": "block"
                        });
                        $("#cancel_" + id).css({
                            "display": "block"
                        });
                    } else {
                        $("#update_" + element).css({
                            "display": "block"
                        });
                        $("#delete_" + element).css({
                            "display": "block"
                        });
                        $("#update_" + element).attr("disabled", true);
                        $("#delete_" + element).attr("disabled", true);
                        $("#save_" + element).css({
                            "display": "none"
                        });
                        $("#cancel_" + element).css({
                            "display": "none"
                        });
                    }
                }
            })
            $(document).on('click', '.cancel_data', function() {
                var id = $(this).data('id_del');
                var id_string = $(this).data('id_string');
                var allProducts = id_string.split('/');
                var newArr = allProducts.splice(0, allProducts.length - 1);
                for (let index = 0; index < newArr.length; index++) {
                    const element = newArr[index];
                    if (id == element) {
                        $("#code_" + id).attr("contenteditable", false);
                        $("#name_" + id).attr("contenteditable", false);
                        $("#price_" + id).attr("contenteditable", false);
                        $("#quantity_" + id).attr("contenteditable", false);
                        $("#code_" + id).css("background-color", "");
                        $("#name_" + id).css("background-color", "");
                        $("#price_" + id).css("background-color", "");
                        $("#quantity_" + id).css("background-color", "");
                        $("#action_" + id).css("background-color", "");
                        $("#update_" + id).css({
                            "display": "block"
                        });
                        $("#delete_" + id).css({
                            "display": "block"
                        });
                        $("#save_" + id).css({
                            "display": "none"
                        });
                        $("#cancel_" + id).css({
                            "display": "none"
                        });
                    } else {
                        $("#update_" + element).css({
                            "display": "block"
                        });
                        $("#delete_" + element).css({
                            "display": "block"
                        });
                        $("#update_" + element).attr("disabled", false);
                        $("#delete_" + element).attr("disabled", false);
                        $("#save_" + element).css({
                            "display": "none"
                        });
                        $("#cancel_" + element).css({
                            "display": "none"
                        });
                    }
                }
                fetch_data();
            });
        });
    </script>
    <script src="http://localhost:8888/PHP_MVC/app/public/JS/hideShow.js"></script>
</body>

</html>