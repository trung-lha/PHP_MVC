<?php
class ProductController extends Controller
{

    public $data = [];
    protected $modelProduct;
    function __construct()
    {
        $this->modelProduct = $this->model("ProductModel");
    }

    public function index()
    {
        $all = $this->modelProduct->buildQueryParams([
            "select" => "*",
            "where" => "",
        ])->selectAll();
        echo '<pre>';
        print_r($all[0]);
        echo '</pre>';
    }


    public function fetchData()
    {
        $out_put = '';
        $allProducts = $this->modelProduct->buildQueryParams([
            "select" => "*",
            "where" => "",
        ])->selectAll();
        $out_put .= '
        <table class="customers">
            <thead>
                <tr>
                    <th>Product code</th>
                    <th>Product name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th style="display:flex; justify-content: center">Action</th>
                </tr>
            </thead>
            <tbody>';
        if (!empty($allProducts)) {
            $string_Id = '';
            foreach ($allProducts as $product) {
                $string_Id .= $product["id"] . "/";
            }
            foreach ($allProducts as $product) {
                $out_put .= '
                <tr>
                    <td id=' . "code_" .  $product["id"] . '>' . $product["code"] . '</td>
                    <td id=' . "name_" .  $product["id"] . '>' . $product["name"] . '</td>
                    <td id=' . "price_" .  $product["id"] . '>' . $product["price"] . '</td>
                    <td id=' . "quantity_" .  $product["id"] . '>' . $product["quantity"] . '</td>
                    <td id=' . "action_" .  $product["id"] . ' style="display:flex; justify-content: space-evenly">
                    <button id=' . "update_" .  $product["id"] . ' class="btn btn-warning update_data" data-id_del=' . $product["id"] . ' data-id_string=' . $string_Id . '>Update</button>
                    <button id=' . "delete_" .  $product["id"] . ' class="btn btn-danger del_data" data-id_del=' . $product["id"] . ' data-toggle="modal" data-target="#exampleModal">Delete</button>
                    <button id=' . "save_" .  $product["id"] . ' class="btn btn-success save_data" data-id_update=' . $product["id"] . ' style="display:none" >Save</button>
                    <button id=' . "cancel_" .  $product["id"] . ' class="btn btn-danger cancel_data" data-id_del=' . $product["id"] . ' data-id_string=' . $string_Id . ' style="display:none" >Cancel</button>
                    </td>
                </tr>
            ';
            }
        } else {
            $out_put .= '
            <tr>
                <td colspan="5" style="text-align: center">No data</td>
            </tr>
        ';
        }
        $out_put .= '
        </tbody>
    </table>
    ';
        $this->data['product_list'] = $out_put;
        $this->render('products/index', $this->data);
    }

    public function reloadData () {
        $out_put = '';
        $allProducts = $this->modelProduct->buildQueryParams([
            "select" => "*",
            "where" => "",
        ])->selectAll();
        $out_put .= '
        <table class="customers">
            <thead>
                <tr>
                    <th>Product code</th>
                    <th>Product name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th style="display:flex; justify-content: center">Action</th>
                </tr>
            </thead>
            <tbody>';
        if (!empty($allProducts)) {
            $string_Id = '';
            foreach ($allProducts as $product) {
                $string_Id .= $product["id"] . "/";
            }
            foreach ($allProducts as $product) {
                $out_put .= '
                <tr>
                    <td id=' . "code_" .  $product["id"] . '>' . $product["code"] . '</td>
                    <td id=' . "name_" .  $product["id"] . '>' . $product["name"] . '</td>
                    <td id=' . "price_" .  $product["id"] . '>' . $product["price"] . '</td>
                    <td id=' . "quantity_" .  $product["id"] . '>' . $product["quantity"] . '</td>
                    <td id=' . "action_" .  $product["id"] . ' style="display:flex; justify-content: space-evenly">
                    <button id=' . "update_" .  $product["id"] . ' class="btn btn-warning update_data" data-id_del=' . $product["id"] . ' data-id_string=' . $string_Id . '>Update</button>
                    <button id=' . "delete_" .  $product["id"] . ' class="btn btn-danger del_data" data-id_del=' . $product["id"] . ' data-toggle="modal" data-target="#exampleModal">Delete</button>
                    <button id=' . "save_" .  $product["id"] . ' class="btn btn-success save_data" data-id_update=' . $product["id"] . ' style="display:none" >Save</button>
                    <button id=' . "cancel_" .  $product["id"] . ' class="btn btn-danger cancel_data" data-id_del=' . $product["id"] . ' data-id_string=' . $string_Id . ' style="display:none" >Cancel</button>
                    </td>
                </tr>
            ';
            }
        } else {
            $out_put .= '
            <tr>
                <td colspan="5" style="text-align: center">No data</td>
            </tr>
        ';
        }
        $out_put .= '
            </tbody>
        </table>
        ';

        echo $out_put;
    }

    public function add()
    {
        if (isset($_POST['name'])) {
            $code = $_POST['code'];
            $allProducts = $this->modelProduct->buildQueryParams([
                "select" => "*",
                "where" => "",
            ])->selectAll();
            $checkCode = 0;
            foreach ($allProducts as $key => $product) {
                if ($product["code"] == $code) {
                    $checkCode = 1;
                }
            }
            if ($checkCode == 0) {
                $name = $_POST['name'];
                $price = $_POST['price'];
                $quantity = $_POST['quantity'];

                $insertProduct = $this->modelProduct->buildQueryParams([
                    "field" => "(name,price,quantity,code) values (?,?,?,?)",
                    "values" => [$name, $price, $quantity, $code],
                ])->insert();
                echo 1;
            } else {
                echo 0;
            }
        }
        // echo "faoehifioa";
    }

    public function update()
    {
        if (isset($_POST['code'])) {
            $code = $_POST['code'];
            $id = $_POST['id'];
            $allProducts = $this->modelProduct->buildQueryParams([
                "select" => "*",
                "where" => "",
            ])->selectAll();
            $checkCode = 0;
            foreach ($allProducts as $key => $product) {
                if ($product["code"] == $code && $product["id"] != $id) {
                    $checkCode = 1;
                }
            }
            if ($checkCode == 0) {
                $name = $_POST['name'];
                $price = $_POST['price'];
                $quantity = $_POST['quantity'];

                $data = [$id, $name, $price, $quantity, $code];

                $up = $this->modelProduct->buildQueryParams([
                    "where" => "id = " . $id,
                    "values" => [$name, $price, $quantity, $code],
                ])->updateProduct($data);
                echo 1;
            } else {
                echo $error = 0;
            }
        }
    }

    public function delete()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $delProduct = $this->modelProduct->buildQueryParams([
                "where" => "id = " . $id,
            ])->delete();
        }
    }
}
