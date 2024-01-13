<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class ProductController extends Controller
{

    function ProductPage():view
    {

        return view ('pages.dashboard.product-page');
    }


    function CreateProduct ( Request $request )
    {
        $user_id=$request->header(  "id"  );

        // Prepare File Name & Path
        $img=$request->file( 'img');
        $t=time();
        $file_name=$img->getClientOriginalName();
        $img_name="{ $user_id }-{ $t }-{ $file_name }";
        $img_url="uploads/$img_name";


        // Upload File
        $img->move(public_path('uploads'),$img_name);


        // Save To Database

        return Product::create([

            'name'=>$request->input('name'),
            'price'=>$request->input('price'),
            'unit'=>$request->input('unit'),
            'img_url'=>$request->input('img_url'),
            'category_id'=>$request->input('category_id'),
            'user_id'=>$user_id



        ]);
    }






    function DeleteProduct(Request $request){





    }







    function ProductByID(Request $request){








    }







    function ProductList(Request $request){





    }







    function UpdateProduct(Request $request){






    }

















}
