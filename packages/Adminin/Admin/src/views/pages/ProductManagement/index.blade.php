@extends('Admin::layouts.master')
@section('content')

    <div ng-app="productManagementApp" >
        <ui-view></ui-view>
    </div>
@endsection
@section('script')

    <script src="{!! asset('/angular/ui-bootstrap-tpls-2.5.0.min.js') !!}"></script>

    <script>
        var productManagementApp = angular.module('productManagementApp', ['ui.router','ngSanitize','ngFileUpload','ui.bootstrap']);

        /*              Routing                   */

        productManagementApp.config(function($stateProvider,$urlRouterProvider) {

            var indexState = {
                name: 'index',
                url: '/view-products',
                controller : 'ProductsController',
                templateUrl: '/partials/Admin/ProductManagement/view-products.html'
            };

            var addProductState = {
                name: 'addProducts',
                url: '/add-products',
                controller : 'AddProductsController',
                templateUrl: '/partials/Admin/ProductManagement/add-products.html'
            };

            var editProductState = {
                name: 'editProduct',
                url: '/edit-product',
                controller : 'EditProductController',
                templateUrl: '/partials/Admin/ProductManagement/edit-product.html'
            };

            var productDetailsState = {
                name: 'productDetails',
                url: '/product-details',
                controller : 'ProductDetailsController',
                templateUrl: '/partials/Admin/ProductManagement/product-details.html'
            };

            var productImagesState = {
                name: 'productImages',
                url: '/product-images',
                controller : 'ProductImagesController',
                templateUrl: '/partials/Admin/ProductManagement/product-images.html'
            };


            $urlRouterProvider.otherwise('/index');
            $stateProvider.state(indexState);
            $stateProvider.state(addProductState);
            $stateProvider.state(editProductState);
            $stateProvider.state(productDetailsState);
            $stateProvider.state(productImagesState);
        });

        productManagementApp.service('SharedProperties',function () {
           
        });

        /*############################################################################################################*/
                                    /*       Controllers       */
        /*############################################################################################################*/


        productManagementApp.controller('ProductsController',function ($scope,$http,Upload,$state,SharedProperties,$log,$filter) {
           
            var products = $http.get('/admin/fetch-products');
            SharedProperties.allProducts=products;
            products.then(function (products,status,headers,config) {
                $scope.products = products.data.data;

                $scope.button =1;
                $scope.lastPage=products.data.last_page;
                $scope.totalPages=$scope.lastPage;
                $scope.currentVisible= products.data.current_page;
                $scope.currentVisiblepage= products.data.current_page;
                $scope.itemsPerpage = products.data.per_page;
                $scope.nextUrl = products.data.next_page_url;
                $scope.firstUrl = products.data.first_page_url;
                $scope.lastUrl = products.data.last_page_url;
                $scope.prevUrl = products.data.prev_page_url;

                $scope.totalPages=$scope.lastPage;
                if($scope.lastPage>10) {
                    $scope.highValue = 10;
                    $scope.lowValue = 1;
                }
                else{
                    $scope.highValue = $scope.lastPage;
                    $scope.lowValue = 1;
                }
                $scope.getNumber = function() {
                    {
                        $scope.paginationArray=[];
                        for (var i= $scope.lowValue;i<=$scope.highValue;i++){
                            $scope.paginationArray.push(i)
                        }
                        return $scope.paginationArray;
                    }
                };

                //*******************pagination-**************//
                $scope.LoadFirstData =function () {

                    var products = $http.get($scope.firstUrl);

                    if(products!=null) {
                        products.then(function (products, status, headers, config) {

                            $("#load-this").hide();

                            $scope.currentVisible = products.data.current_page;
                            $scope.currentVisiblepage = products.data.current_page;
                            $scope.itemsPerpage = products.data.per_page;
                            $scope.products = products.data.data;
                            $scope.nextUrl = products.data.next_page_url;
                            $scope.firstUrl = products.data.first_page_url;
                            $scope.lastUrl = products.data.last_page_url;
                            $scope.prevUrl = products.data.prev_page_url;
                            $scope.lastPage=products.data.last_page;
                            $scope.button =$scope.currentVisible;
                            if($scope.lastPage>10) {
                                $scope.highValue = 10;
                                $scope.lowValue = 1;
                            }else{
                                $scope.highValue = $scope.lastPage;
                                $scope.lowValue = 1;
                            }
                            $scope.getNumber();
                        });
                    }
                };

                //*******************pagination-**************//
                $scope.LoadLastData =function () {

                   var products = $http.get($scope.lastUrl);

                    if(products!=null) {
                        products.then(function (products, status, headers, config) {

                            $("#load-this").hide();
                            $scope.currentVisible = products.data.current_page;
                            $scope.currentVisiblepage = products.data.current_page;
                            $scope.itemsPerpage = products.data.per_page;
                            $scope.products = products.data.data;
                            $scope.nextUrl = products.data.next_page_url;
                            $scope.firstUrl = products.data.first_page_url;
                            $scope.lastUrl = products.data.last_page_url;
                            $scope.prevUrl = products.data.prev_page_url;
                            $scope.lastPage=products.data.last_page;
                            if($scope.lastPage>10) {
                                $scope.highValue = $scope.lastPage;
                                $scope.lowValue = $scope.lastPage-9;
                            }
                            else{
                                $scope.highValue = $scope.lastPage;
                                $scope.lowValue = 1;

                            }
                            $scope.button =  $scope.currentVisible;
                            $scope.getNumber();
                        });
                    }
                };

                $scope.getNumber();
                $scope.selectedPageUrl=function(selectedPage,index) {

                    var products = $http.get('/admin/fetch-products?page=' + selectedPage);

                    products.then(function (products, status, headers, config) {

                        $scope.currentVisiblepage= products.data.current_page;
                        $scope.currentVisible = products.data.current_page;
                        $scope.products = products.data.data;
                        $scope.lastPage=products.data.last_page;
                        $scope.firstUrl = products.data.first_page_url;
                        $scope.totalPages=products.data.last_page;
                        $scope.lastUrl = products.data.last_page_url;
                        $scope.nextUrl = products.data.next_page_url;
                        $scope.prevUrl = products.data.prev_page_url;
                        $scope.button =  $scope.currentVisible;
                    });

                };

                $scope.LoadNextData=function() {

                    if($scope.nextUrl==null){
                    }
                    else var products = $http.get($scope.nextUrl);

                    if(products!=null) {
                        products.then(function (products, status, headers, config) {
                            $scope.currentVisible = products.data.current_page;
                            $scope.products = products.data.data;
                            $scope.firstUrl = products.data.first_page_url;
                            $scope.nextUrl = products.data.next_page_url;
                            $scope.prevUrl = products.data.prev_page_url;
                            $scope.lastUrl = products.data.last_page_url;
                            $scope.totalPages = products.data.last_page;
                            $scope.currentVisiblepage = products.data.current_page;

                            if($scope.highValue<$scope.totalPages) {
                                $scope.highValue = $scope.highValue + 1;
                                $scope.lowValue = $scope.lowValue + 1;
                                $scope.getNumber();
                            }
                            $scope.button=$scope.currentVisiblepage;
                        });
                    }
                };

                $scope.LoadPreviousData=function() {

                    if($scope.prevUrl==null){
                    }
                        else var products = $http.get($scope.prevUrl);

                    if(products!=null) {
                        products.then(function (products, status, headers, config) {
                            $scope.currentVisible = products.data.current_page;
                            $scope.products = products.data.data;
                            $scope.nextUrl = products.data.next_page_url;
                            $scope.firstUrl = products.data.first_page_url;
                            $scope.prevUrl = products.data.prev_page_url;
                            $scope.totalPages = products.data.last_page;
                            $scope.lastUrl = products.data.last_page_url;
                            $scope.currentVisiblepage = products.data.current_page;
                            if($scope.lowValue>1) {
                                $scope.highValue = $scope.highValue - 1;
                                $scope.lowValue = $scope.lowValue - 1;
                                $scope.getNumber();
                            }
                            $scope.button=$scope.currentVisiblepage;
                        });
                    }

                };
            });

            $scope.editProduct = function (product) {
                SharedProperties.selectedProduct=product;
                $state.go('editProduct');
            }

            $scope.viewDetails = function (product) {
                SharedProperties.selectedProduct=product;
                var categoryDetails = $http.post('/admin/get-product-category',{category_id:SharedProperties.selectedProduct.category_id});
                categoryDetails.then(function (categoryDetails, status, headers, config)
                {
                    $scope.categoryDetails=categoryDetails.data;
                });
                
                $state.go('productDetails');
            }

               
            $scope.viewPhotos =function (product) {
                SharedProperties.selectedProduct=product;      
                $state.go('productImages');  
            };

            $scope.addPhoto =function (product) {
                $scope.productId= product.id; 
                $scope.addMultiplePhotos=function (file,errFiles)
                {
                    Upload.upload({
                        url: '/admin/product-photo-upload',
                        data : {file: file,
                            productId: $scope.productId
                        }
                    }).then(function (data) {                    
                        $("#load-this").hide();
                        $("#passwordReset").hide();
                        $scope.multipleFile="";
                        swal("", "Product Added Successfully", "success");                                              
                    }).catch(function(data) {
                        $("#load-this").hide();
                         $scope.multipleFile="";
                    });
                };   
                
            };

            
        });


        /*   Controller to store the product details. The data is passed to ProductManagementController's store function   */
        productManagementApp.controller('AddProductsController',function ($scope,$http,Upload,$state,SharedProperties,$log,$filter) {
                        
            var categoryDetails = $http.get('/admin/get-categories') 
            categoryDetails.then(function (categoryDetails, status, headers, config)
                {
                    $scope.categoryDetails=categoryDetails.data;
                });

            $(document).ready(function() {
                $('#categorySelect2').select2();
            });

            $scope.findSubCategory =function (selectedCategory) {

                var findSubCategories=$http.post('/admin/find-subcategory', {category_id:selectedCategory.id})
                findSubCategories.then(function (findSubCategories, status, headers, config) {
                    $scope.SubCategoryDetails = findSubCategories.data;
                });
            };

            $scope.uploadCategoryDetails = function(file,errFiles) {
                var product_id = $scope.product.product_id;
                var catergory_id = $scope.selectedCategory.id;
                var category = $scope.selectedCategory.name;
                var subcategory_id = $scope.selectedSubCategory.id;
                var subcategory = $scope.selectedSubCategory.sub_category_name;
                var product_name = $scope.product.name;
                var old_price =$scope.product.oldprice;
                var new_price =$scope.product.newprice;
                var link =$scope.product.link;
                var description = $scope.product.description;
                $("#load-this").show();
                Upload.upload({
                    url: '/admin/products',
                    data : {file: file,
                        product_id:product_id,
                        catergory_id: catergory_id,
                        category:category,
                        subcategory_id: subcategory_id,
                        subcategory:subcategory,
                        product_name: product_name,
                        old_price: old_price,
                        new_price: new_price,
                        link:link,
                        description: description,
                    }
                }).then(function (data) {                    
                    $("#load-this").hide();
                    $scope.product.name=''; 
                    $scope.product.product_id=''; 
                    $scope.product.oldprice='';
                    $scope.product.oldprice ='';
                    $scope.product.newprice ='';
                    $scope.product.link ='';
                    $scope.product.description ='';
                    $scope.selectedCategory ='';
                    $scope.selectedSubCategory ='';
                    document.getElementById('product-image').src=null;
                    swal("", "Product Added Successfully", "success");                                              
                }).catch(function(data) {
                    $("#load-this").hide();
                });

            }
        });


        /*############################################################################################################*/
        /*  Controller to show the details of respective sites  */
        productManagementApp.controller('ProductDetailsController',function ($scope,$http,$state,SharedProperties,$log,$filter) {
              $scope.selectedProduct=SharedProperties.selectedProduct;
              if ($scope.selectedProduct == null){
                $state.go('index');
            }

        });

        /*############################################################################################################*/
        /*  Controller to show the details of respective sites  */
        productManagementApp.controller('ProductImagesController',function ($scope,$http,$state,SharedProperties,$log,$filter) {
                $scope.selectedProduct=SharedProperties.selectedProduct;
                if ($scope.selectedProduct == null){
                    $state.go('index');
                }
                else{
                var productDetails = $http.post('/admin/get-product-photos',{product_id:$scope.selectedProduct.id});         
                productDetails.then(function (productDetails, status, headers, config)
                    {
                        $scope.productDetails=productDetails.data;
                    });    

                
                    $scope.deleteProductImage=function (imageId)
                    {
                        var result = confirm("Are you sure?");
                        if (result == true) {   
                        var deleteProductImage = $http.post('/admin/product-delete/{id}',{product_id:imageId});  
                        }
                        else{

                            }  
                    };   
                }                       
        });

        /*############################################################################################################*/
        /*  Controller to edit the product details */
        productManagementApp.controller('EditProductController',function ($scope,$http,Upload,$state,SharedProperties,$log,$filter) {
            $scope.editProduct = SharedProperties.selectedProduct;

            /* checks if the field values are empty, redirects to the view-sites pages */
            if ($scope.editProduct == null){
                $state.go('index');
            }
            var category_id=$scope.editProduct.category_id;

            
            var categoryDetails = $http.post('/admin/find-category',{category_id:category_id}) 
            categoryDetails.then(function (categoryDetails, status, headers, config)
                {
                    $scope.editCategoryDetails=categoryDetails.data.categories;
                    $scope.editselectedCategory= $scope.editCategoryDetails[getcategoryIndex()]; 
                    $scope.editSubCategoryDetails=categoryDetails.data.subcategories;   
                    $scope.editSelectedSubCategory= $scope.editSubCategoryDetails[getsubcategoryIndex()];                  
                });

                function getcategoryIndex() {
                    var index;
                    for (var i = 0;i<$scope.editCategoryDetails.length;i++){
                        if ($scope.editCategoryDetails[i].id == $scope.editProduct.category_id){
                            index = i;
                        }
                    }

                    return index;
                };

                function getsubcategoryIndex() {
                    var index;
                    for (var i = 0;i<$scope.editSubCategoryDetails.length;i++){
                        if ($scope.editSubCategoryDetails[i].id == $scope.editProduct.sub_category_id){
                            index = i;
                        }
                    }

                    return index;
                };


                $scope.editfindSubCategory =function (editselectedCategory) {
                    var editFetchDetails=$http.post('/admin/find-category', {category_id:editselectedCategory.id})
                    editFetchDetails.then(function (editFetchDetails, status, headers, config) {
                        $scope.editSubCategoryDetails = editFetchDetails.data.subcategories;
                    });

                };

            $(document).ready(function() {
                $('#categorySelect2').select2();
            });

            $scope.findSubCategory =function (editselectedCategory) {

                var SubCategories=$http.post('/admin/find-subcategory', {category_id:editSelectedCategory.id})
                findSubCategories.then(function (findSubCategories, status, headers, config) {
                    $scope.editSubCategoryDetails = findSubCategories.data;
                });
            };  

            $scope.updateProductDetails = function(file) {
                var id = $scope.editProduct.id;
                var product_id = $scope.editProduct.productId;
                var category_id = $scope.editselectedCategory.id;
                var category = $scope.editselectedCategory.name;
                var subcategory_id = $scope.editSelectedSubCategory.id;
                var subcategory = $scope.editSelectedSubCategory.sub_category_name;
                var product_name = $scope.editProduct.product_name;
                var old_price =$scope.editProduct.old_price;
                var new_price =$scope.editProduct.new_price;
                var link =$scope.editProduct.link;
                var description = $scope.editProduct.description;
                $("#load-this").show();
                Upload.upload({
                    url: '/admin/product-update',
                    data : {file: file,
                        id:id,
                        product_id:product_id,
                        category_id: category_id,
                        category:category,
                        subcategory_id: subcategory_id,
                        subcategory:subcategory,
                        product_name: product_name,
                        old_price: old_price,
                        new_price: new_price,
                        link:link,
                        description: description,
                    }
                }).then(function (data) { 
                console.log(data)   ;                
                    $("#load-this").hide();
                    $scope.product.name=''; 
                    $scope.product.product_id=''; 
                    $scope.product.oldprice='';
                    $scope.product.oldprice ='';
                    $scope.product.newprice ='';
                    $scope.product.link ='';
                    $scope.product.description ='';
                    $scope.selectedCategory ='';
                    $scope.selectedSubCategory ='';
                    document.getElementById('product-image').src=null;
                    swal("", "Product Added Successfully", "success");                                              
                }).catch(function(data) {
                    $("#load-this").hide();
                });

            }

          
        });



    </script>
@endsection
