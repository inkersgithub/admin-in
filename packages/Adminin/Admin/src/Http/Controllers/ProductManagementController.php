<?php

namespace Adminin\Admin\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Product;
use App\ProductImage;
use App\Category;
use App\SubCategory;
use Session;
use Intervention\Image\ImageManagerStatic as Image;

// imagesize:450x600
class ProductManagementController extends BaseController
{

    ######################################## To display the index page to list sites ###################################
    public function index()
    {
        return $this->view('pages.ProductManagement.index');
    }

    ####################################################################################################################
    public function fetchCategory(Request $request)
    {
        $categoryId=$request->category_id;
        $CategoryDetails=Category::where('status','=',1)->get();
        $subCategoryDetails=SubCategory::where('category_id','=',$categoryId)->where('status','=',1)->get();
       return response()->json(array('categories'=>$CategoryDetails,'subcategories'=>$subCategoryDetails));
    }

    ####################################################################################################################
    public function fetchSubCategories(Request $request)
    {
        $categoryId=$request->category_id;
        $subCategoryDetails=SubCategory::where('category_id','=',$categoryId)->where('status','=',1)->get();
        return $subCategoryDetails;
    }

    ############################### To store the validated category details in the categories table ####################
    public function store(Request $request)
    {
        $Store = new Product;
        $Store->productId= $request->product_id;
        $Store->category_id= $request->catergory_id;
        $Store->category= $request->category;       
        $Store->sub_category_id= $request->subcategory_id;
        $Store->subcategory= $request->subcategory;
        $Store->product_name= $request->product_name;
        $Store->old_price= $request->old_price;
        $Store->new_price= $request->new_price;
        $Store->link= $request->link;
        $Store->description= $request->description;

        if($request->hasFile('file')) {
            $filename = $request->file->getClientOriginalName();
            $request->file->move(public_path('storage/ProductThumbnail/'), $filename);
            $Store->image = $filename;
        }
        $Store->save();
    }

    ############################### To store the validated category details in the categories table ####################
    public function productUpdate(Request $request)
    {
        $id=$request->id;
        $productUpdate = Product::findOrFail($id);
        $productUpdate->productId= $request->product_id;
        $productUpdate->category_id= $request->category_id;
        $productUpdate->category= $request->category;       
        $productUpdate->sub_category_id= $request->subcategory_id;
        $productUpdate->subcategory= $request->subcategory;
        $productUpdate->product_name= $request->product_name;
        $productUpdate->old_price= $request->old_price;
        $productUpdate->new_price= $request->new_price;
        $productUpdate->link= $request->link;
        $productUpdate->description= $request->description;
        if($request->hasFile('file')) {
            $filename = $request->file->getClientOriginalName();
            $request->file->move(public_path('storage/ProductThumbnail/'), $filename);
            $productUpdate->image = $filename;
        }
        $productUpdate->save();
    }

     ##################################### Code to upload tournament photos to table #####################################
    public function uploadProductPhotos(request $request)
    {
        $product_id=$request->productId;
//        $directoryName = '/storage/ProductsImages';
//        if(!is_dir($directoryName)){
//            mkdir($directoryName, 0777, true);
//        }
        if($request->hasFile('file')){
            foreach($request->file as $file) {
                $filename=$file->getClientOriginalName();
                $file->move('storage/ProductsImages',$filename);
                $productPhoto = new ProductImage;
                $productPhoto->product_id = $product_id;
                $productPhoto->file_name = $filename;
                $productPhoto->save();
            }
        }
        return 1;
    }

    ####################################################################################################################
    public function fetchProducts(Request $request)
    {
        return $products=Product::paginate(10);
    }

    ####################################################################################################################
    public function editCategory(Request $request)
    {
        $category_id=$request->category_id;
        $mainCategory=Category::where('id','=',$category_id)->where('status','=',1)->get();
        $subCategory=subCategory::where('category_id',$category_id)->where('status','=',1)->get();

        return response()->json(array('category'=>$mainCategory,'sub_category'=>$subCategory));

    }

    ####################################################################################################################
    public function getProductCategory(Request $request)
    {
        $category_id=$request->category_id;
        $categoryName=Category::where('id','=',$category_id)
                        ->get();
        return $categoryName;
    }

    ####################################################################################################################
    public function getProductPhotos(Request $request)
    {
        $product_id=$request->product_id;
        $productImages=ProductImage::where('product_id','=',$product_id)->get();
        return $productImages;
    }

    ####################################################################################################################
    public function ProductPhotoDelete(Request $request)
    {
        $ProductPhotoDelete = ProductImage::where('id','=',$request->product_id)->delete();
    }

}
