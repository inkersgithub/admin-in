<?php

namespace Adminin\Admin\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\Common\Delete;
use Session;

class CategoryManagementController extends BaseController
{

    ######################################## To display the index page to list categories ##############################
    public function index()
    {
        return $this->view('pages.CategoryManagement.index');
    }

    ############################### To store the validated category details in the categories table ####################
    public function store(Request $request)
    {
        $Store = new Category;
        $Store->name= $request->name;
        $Store->description= $request->description;
        $Store->save();
    }

    ######################################## To update the edited category details #####################################
    public function categoryUpdate(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required',
            ]);

        $id=$request->category_id;
        $Store = Category::findOrFail($id);
        $Store->name= $request->name;
        $Store->description= $request->description;
        $Store->save();
    }

    ################################### To disable an active category ##################################################
    public function disableCategoryStatus(Request $request)
    {
        $id=$request->category_id;

        $disable = Category::findOrFail($id);
        $disable->status = 0;
        $disable->save();
        return 1;
    }

    ################################################ To enable an inactive category ####################################
    public function enableCategoryStatus(Request $request)
    {
        $id=$request->category_id;

        $enable = Category::findOrFail($id);
        $enable->status = 1;
        $enable->save();
        return 1;
    }

    ############################### To store the subcategory details in the sub_categories table #######################
    public function addSubCategory(Request $request)
    {
        $Store = new SubCategory;
        $Store->sub_category_name= $request->name;
        $Store->category_id= $request->category_id;
        $Store->description= $request->description;
        $Store->save();
    }

    ############################### To fetch the subcategories details #################################################
    public function getSubCategories(Request $request)
    {
        $category_id=$request->category_id;
        return $subCategory = SubCategory::where('category_id','=',$category_id)->get();
    }

    ######################################## To update the subcategory details #########################################
    public function updateSubCategories(Request $request)
    {
        $id=$request->id;
        $Store = SubCategory::findOrFail($id);
        $Store->sub_category_name= $request->name;
        $Store->category_id= $request->category_id;
        $Store->description= $request->description;
        $Store->save();
    }

    ############################### To fetch the subcategories details #################################################
    public function deleteCategory(Request $request)
    {
       $category_id=$request->id;
       $delete = Category::where('id','=',$category_id)->delete();

       return $subCategory = Category::all();
    }

    ############################### To fetch the subcategories details #################################################
    public function deleteSubCategory(Request $request)
    {
       $sub_category_id=$request->id;
       $delete = SubCategory::where('id','=',$sub_category_id)->delete();

       return $subCategory = SubCategory::all();
    }

    ################################# To fetch the categories from the categories table ###############################
    public function getCategories()
    {
        return $categories=Category::all();
    }

    ####################################################################################################################
}
