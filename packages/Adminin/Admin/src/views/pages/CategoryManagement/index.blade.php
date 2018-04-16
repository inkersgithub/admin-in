@extends('Admin::layouts.master')
@section('content')

    <div ng-app="categoryManagementApp" >
        <ui-view></ui-view>
    </div>
@endsection
@section('script')

    <script src="{!! asset('/angular/ui-bootstrap-tpls-2.5.0.min.js') !!}"></script>

    <script>
        var categoryManagementApp = angular.module('categoryManagementApp', ['ui.router','ngSanitize','ngFileUpload','ui.bootstrap']);

        /*              Routing                   */

        categoryManagementApp.config(function($stateProvider,$urlRouterProvider) {

            var indexState = {
                name: 'index',
                url: '/view-categories',
                controller : 'CategoryController',
                templateUrl: '/partials/Admin/CategoryManagement/view-categories.html'
            };

            var addCategoryState = {
                name: 'addCategory',
                url: '/add-categories',
                controller : 'AddCategoryController',
                templateUrl: '/partials/Admin/CategoryManagement/add-category.html'
            };

            var categoryDetails = {
                name: 'categoryDetails',
                url: '/category-details',
                controller : 'ShowController',
                templateUrl: '/partials/Admin/CategoryManagement/show.html'
            };

            var editCategoryState = {
                name: 'editCategory',
                url: '/edit-category',
                controller : 'EditCategoryController',
                templateUrl: '/partials/Admin/CategoryManagement/edit-category.html'
            };

            var addSubCategoryState = {
                name: 'addSubCategory',
                url: '/add-sub-category',
                controller : 'AddSubCategoryController',
                templateUrl: '/partials/Admin/CategoryManagement/add-sub-category.html'
            };

            var viewSubCategoryState = {
                name: 'viewSubCategory',
                url: '/view-sub-category',
                controller : 'ViewSubCategoryController',
                templateUrl: '/partials/Admin/CategoryManagement/view-sub-categories.html'
            };

            var subCategoryDetailsState = {
                name: 'subCategoryDetails',
                url: '/sub-category-details',
                controller : 'SubCategoryDetailsController',
                templateUrl: '/partials/Admin/CategoryManagement/sub-category-details.html'
            };

            var editSubCategoryState = {
                name: 'editSubCategory',
                url: '/edit-subcategory',
                controller : 'EditSubCategoryController',
                templateUrl: '/partials/Admin/CategoryManagement/edit-sub-category.html'
            };

            $urlRouterProvider.otherwise('/index');
            $stateProvider.state(indexState);
            $stateProvider.state(addCategoryState);
            $stateProvider.state(categoryDetails);
            $stateProvider.state(editCategoryState);
            $stateProvider.state(addSubCategoryState);
            $stateProvider.state(viewSubCategoryState);
            $stateProvider.state(subCategoryDetailsState);
            $stateProvider.state(editSubCategoryState);
        });

        categoryManagementApp.service('SharedProperties',function () {
            var selectedCategory;
        });

        /*############################################################################################################*/
                                    /*       Controllers       */
        /*############################################################################################################*/

        categoryManagementApp.controller('CategoryController',function ($scope,$http,$state,SharedProperties,$log,$filter) {
            var categories = $http.get('/admin/get-categories');
            SharedProperties.allCategories=categories;
            categories.then(function (categories,status,headers,config) {
                $scope.categories = categories.data;
            });

            $scope.disableCategory =function (category) {
                var categoryDisable=$http.post('/admin/category-disable', {category_id:category.id})
                categoryDisable.then(function (categoryDisable, status, headers, config) {
                    category.status = 0;
                });
            }

            $scope.enableCategory =function (category) {
                var categoryEnable=$http.post('/admin/category-enable', {category_id:category.id})
                categoryEnable.then(function (categoryEnable, status, headers, config) {
                    category.status = 1;
                });
            }

            $scope.categoryDetails = function (category) {
                SharedProperties.selectedCategory=category;
                $state.go('categoryDetails');
            }

            $scope.editCategory = function (category) {
                SharedProperties.selectedCategory=category;
                $state.go('editCategory');
            }            

            $scope.addSubCategory = function (category) {
                SharedProperties.selectedCategory=category;
                $state.go('addSubCategory');
            }

            $scope.viewSubCategory = function (category) {
                SharedProperties.selectedCategory=category;
                $state.go('viewSubCategory');
            }

            $scope.deleteCategory = function (category) {
                SharedProperties.selectedCategory=category;
                 var deleteCategory=$http.post('/admin/delete-category', {id:SharedProperties.selectedCategory.id})
                deleteCategory.then(function (deleteCategory, status, headers, config)
                {
                    $scope.categories=deleteCategory.data;
                    console.log($scope.categories);
                    swal("Category Deleted Successfully");
                }).catch(function(data) {
                    $("#load-this").hide();
                });
            } 
        });

        /*############################################################################################################*/
        /*   Controller to store the category details. The data is passed to CategoryManagementController's store function   */
         categoryManagementApp.controller('AddCategoryController',function ($scope,$http,$state,SharedProperties,$log,$filter) {

            $scope.add=function (category)
            {
                var name=category.name;
                var description=category.description;

                var uploadCategoryInfo=$http.post('/admin/category', {name:name,description:description})
                uploadCategoryInfo.then(function (uploadCategoryInfo, status, headers, config)
                {
                    category.name='';
                    category.description='';
                    swal("Category Created Successfully");
                }).catch(function(data) {
                    $("#load-this").hide();
                });


            }

         });

        /*############################################################################################################*/
        /*  Controller to show the details of respective categories  */
        categoryManagementApp.controller('ShowController',function ($scope,$http,$state,SharedProperties,$log,$filter) {
            $scope.categoryDetails = SharedProperties.selectedCategory;
            if($scope.categoryDetails==null){
                $state.go('index');
            }
        });

        /*############################################################################################################*/
        /*  Controller to edit the category details . Data passed to categoryUpdate function of CategoryManagementController. */
        categoryManagementApp.controller('EditCategoryController',function ($scope,$http,Upload,$state,SharedProperties,$log,$filter) {
            $scope.editCategory = SharedProperties.selectedCategory;

            /* checks if the field values are empty, redirects to the view-categories pages */
            if ($scope.editCategory == null){
                $state.go('index');
            }

            $scope.edit=function (editCategory)
            {
                var category_id=editCategory.id;
                var name=editCategory.name;
                var description=editCategory.description;

                var editCategoryInfo=$http.post('/admin/category-update', {category_id:category_id,name:name,description:description})
                editCategoryInfo.then(function (editCategoryInfo, status, headers, config)
                {
                    editCategory.name='';
                    editCategory.description='';
                    swal("Category Details Updated Successfully");
                    $state.go('index');
                }).catch(function(data) {
                    $("#load-this").hide();
                });


            }
        });

        /*############################################################################################################*/
        /* Add SubCategory to the corresponding Category . Data passed to subcategory function of CategoryManagementController*/
        categoryManagementApp.controller('AddSubCategoryController',function ($scope,$http,Upload,$state,SharedProperties,$log,$filter) {

            if(SharedProperties.selectedCategory==null){
                $state.go('index');
                }

                else{
                $scope.addSubCategory=function (category)
                {
                    $scope.category=SharedProperties.selectedCategory;
                    var category_id=$scope.category.id;
                    var name=$scope.sub_category.name;
                    var description=$scope.sub_category.description;

                    var uploadCategoryInfo=$http.post('/admin/sub-category', {category_id:category_id,name:name,description:description})
                    uploadCategoryInfo.then(function (uploadCategoryInfo, status, headers, config)
                    {
                        $scope.sub_category.name='';
                        $scope.sub_category.description='';
                        swal("Sub Category Created Successfully");
                    }).catch(function(data) {
                        $("#load-this").hide();
                    });
                }
            }
        });

        /*############################################################################################################*/
        /* Add SubCategory to the corresponding Category . Data passed to subcategory function of CategoryManagementController*/
        categoryManagementApp.controller('ViewSubCategoryController',function ($scope,$http,Upload,$state,SharedProperties,$log,$filter) {

            $scope.category=SharedProperties.selectedCategory;
            
                if($scope.category==null){
                    $state.go('index');
                }
                else{
                var category_id=$scope.category.id;

                var subCategoryInfo = $http.post('/admin/get-sub-categories',{category_id:category_id})
                subCategoryInfo.then(function (subCategoryInfo, status, headers, config)
                    {
                        $scope.subcategories=subCategoryInfo.data;
                    });

            $scope.subCategoryDetails = function (subcategory) {
                SharedProperties.SelectedSubCategory=subcategory;
                $state.go('subCategoryDetails');
            }

            $scope.editSubCategoryDetails = function (subcategory) {
                SharedProperties.SelectedSubCategory=subcategory;
                $state.go('editSubCategory');
            }

            $scope.deleteSubCategory = function (subcategory) {
                var result = confirm("Are you sure?");
                if (result == true) {
                    $scope.subcategory=subcategory;
                    var deleteSubCategory=$http.post('/admin/delete-sub-category', {id:$scope.subcategory.id})
                    deleteSubCategory.then(function (uploadCategoryInfo, status, headers, config)
                        {
                            $scope.subcategories=deleteSubCategory.data;
                            $state.go('index');
                        });
                    }
                }
            }
            
            });

        /*############################################################################################################*/
        /* Controller to show the full details of the selected subcategory */
        categoryManagementApp.controller('SubCategoryDetailsController',function ($scope,$http,$state,SharedProperties,$log,$filter) {
            $scope.subCategoryDetails = SharedProperties.SelectedSubCategory;
            if ($scope.subCategoryDetails == null){
                $state.go('index');
            }
        });

        /*############################################################################################################*/
        /* Controller to Edit SubCategory */
        categoryManagementApp.controller('EditSubCategoryController',function ($scope,$http,Upload,$state,SharedProperties,$log,$filter) {

            $scope.subcategory = SharedProperties.SelectedSubCategory;
            if ($scope.subcategory == null){
                $state.go('index');
            }
            $scope.editSubCategory=function (subcategory)
            {                
                var id=$scope.subcategory.id;
                var category_id=$scope.subcategory.category_id;
                var name=$scope.subcategory.sub_category_name;
                var description=$scope.subcategory.description;

                var uploadCategoryInfo=$http.post('/admin/update-sub-category', {id:id,category_id:category_id,name:name,description:description})
                uploadCategoryInfo.then(function (uploadCategoryInfo, status, headers, config)
                {
                    swal("Sub Category Details Updated Successfully");
                    $state.go('index');
                }).catch(function(data) {
                    $("#load-this").hide();
                });


            }
        });

        /*############################################################################################################*/
        /* Controller to show the full details of the selected subcategory */
        categoryManagementApp.controller('SubCategoryDetailsController',function ($scope,$http,$state,SharedProperties,$log,$filter) {
            $scope.subCategoryDetails = SharedProperties.SelectedSubCategory;
            if ($scope.subCategoryDetails == null){
                $state.go('index');
            }

        });
     

    </script>
@endsection