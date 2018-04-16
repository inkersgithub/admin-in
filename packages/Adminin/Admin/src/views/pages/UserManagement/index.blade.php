@extends('Admin::layouts.master')
@section('content')

    <div ng-app="usermanagementApp" >
        <ui-view></ui-view>
    </div>
@endsection
@section('script')
    <script src="{!! asset('/angular/ui-bootstrap-tpls-2.5.0.min.js') !!}"></script>
    <script>
        var usermanagementApp = angular.module('usermanagementApp', ['ui.router','ngSanitize','ui.bootstrap']);


        /*
        ** Routings
         */
        usermanagementApp.config(function($stateProvider,$urlRouterProvider) {

            var indexState = {
                name: 'index',
                url: '/view-users',
                controller : 'indexController',
                templateUrl: '/partials/Admin/UserManagement/view-users.html'
            };
            var adduserState = {
                name: 'adduser',
                url: '/add-users',
                controller : 'addUserController',
                templateUrl: '/partials/Admin/UserManagement/add-users.html'
            };

            var editState = {
                name: 'editUser',
                url: '/edit',
                controller : 'editController',
                templateUrl: '/partials/Admin/UserManagement/edit-users.html'
            };

            $urlRouterProvider.otherwise('/index');
            $stateProvider.state(indexState);
            $stateProvider.state(adduserState);
            $stateProvider.state(editState);;

        });
        usermanagementApp.service('SharedProperties',function () {

        });
        /*
        ** Controllers
         */
        /*############################################################################################################*/
        /*       Controllers       */
        /*############################################################################################################*/

        /*Controller to add user details */
        usermanagementApp.controller('addUserController',function ($scope,$http,$state,SharedProperties,$log,$filter) {

            $scope.checkUsername = function(){
                var userStaus=$http.post('/admin/get-username', {username:$scope.user.username})
                userStaus.then(function (userStaus, status, headers, config) {
                    $scope.status = userStaus.data;
                });
            };
            $scope.roles = [

                { value: 1, label: "Admin" },
                { value: 2, label: "Other Admins" }

            ];
            $scope.add=function (user)
            {
                var firstName=user.name;
                var userName=user.username;
                var password=user.password;
                var mobile=user.mobile;
                var role=user.rolesIn.value;
                var email=user.email;

                var uploadUserInfo=$http.post('/admin/users', {name:firstName,username:userName,password:password,email:email,mobile:mobile,role:role})
                uploadUserInfo.then(function (uploadUserInfo, status, headers, config)
                {
                    user.username='';
                    user.password='';
                    user.mobile='';
                    user.email='';
                    user.rolesIn='';
                    swal("User Created Successfully");
                }).catch(function(data) {
                    $("#load-this").hide();
                });


            }

        });

        /*Controller to view the user details */
        usermanagementApp.controller('indexController',function ($scope,$http,$state,SharedProperties,$log,$filter) {
            var users = $http.get('/admin/get-users');
            users.then(function (users,status,headers,config) {
                $scope.users = users.data;

            });
            $scope.disableUser =function (user) {

                var userDisable=$http.post('/admin/user-disable', {user_id:user.id})
                userDisable.then(function (userDisable, status, headers, config) {
                    user.status = 0;
                });
            };
            $scope.enableUser =function (user) {

                var userDisable=$http.post('/admin/user-enable', {user_id:user.id})
                userDisable.then(function (userDisable, status, headers, config) {
                    user.status = 1;
                });

            };
            $scope.editUser = function (user) {
                SharedProperties.selectedUser=user;
                $state.go('editUser');

            };

            $scope.passwordReset =function (user) {
                $scope.userId=user.id;
            };

            $scope.resetPassword=function (password)
            {
            var changeUserPassword=$http.post('/admin/change-password', {userId:$scope.userId,passwordInfo:password.confirmPassword})
                changeUserPassword.then(function (changeUserPassword, status, headers, config) {
                    $("#passwordReset").hide();
                    password.confirmPassword='';
                    password.passwords='';
                    swal("Password Reset Successfully");
                });
            }

            $scope.deleteUser = function (user) {
                SharedProperties.selectedUser=user;
                var deleteuser=$http.post('/admin/delete-user', {id:SharedProperties.selectedUser.id})
                deleteuser.then(function (deleteuser, status, headers, config)
                {
                    $scope.users=deleteuser.data;
                    swal("User Deleted Successfully");
                }).catch(function(data) {
                    $("#load-this").hide();
                });

            };

        });

        usermanagementApp.controller('editController',function ($scope,$http,$state,SharedProperties,$log,$filter) {
            $scope.editUser = SharedProperties.selectedUser;
            if ($scope.editUser == null){
                $state.go('index');
            }

        $scope.roles = [

                { value: 1, label: "Admin" }
                ,
                { value: 2, label: "Other Admins" }

            ];
            $scope.selectedRole= $scope.roles[getRoleIndex()];

            function getRoleIndex() {

                var index;
                for (var i = 0;i<$scope.roles.length;i++){
                    if ($scope.roles[i].value == $scope.editUser.role){
                        index = i;
                    }
                }
                return index;
            };


            $scope.update=function (editUser)
            {

                var updateUserInfo=$http.patch('/admin/users/{id}', {editName:editUser.name,editId:editUser.id,editRole:$scope.selectedRole.value,editUsername:editUser.user_name,editEmail:editUser.email,editMobile:editUser.mobile_no})
                updateUserInfo.then(function (updateUserInfo, status, headers, config)
                {
                    swal("User Details Updated");
                    $state.go('index');

                }).catch(function(data) {
                    $("#load-this").hide();
                });


            };
            $scope.editCheckUsername = function(){


                var userStaus=$http.post('/admin/get-edit-username', {username:$scope.editUser.user_name})
                userStaus.then(function (userStaus, status, headers, config) {
                    $scope.status = userStaus.data;

                });
            }

        });

    </script>
@endsection



