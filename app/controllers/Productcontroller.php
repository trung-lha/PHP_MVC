<?php
    class ProductController extends Controller {

        protected $modelProduct;
        function __construct()
        {
            $this->modelProduct = $this->model("ProductModel");
        }

        function index (){
            $all = $this->modelProduct->buildQueryParams([
                "select" => "*",
                "where" => "",
            ])->selectAll();
            echo '<pre>'; print_r($all[0]); echo '</pre>';
        }
         
    }
?>