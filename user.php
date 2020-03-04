<?php session_start();
if (isset($_SESSION["login"]) != "pass") {
     header("Location: https://coordinatexy.herokuapp.com/");
     //header("Location: http://localhost/coordinatexy/");
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CoordinateXY</title>
    <link rel="shortcut icon" href="assets/images/saladin.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/custom_ui.css">
    <link rel="stylesheet" href="assets/css/custom_avatar.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/fonts/kanit.css">
    <script src="assets/js/sweetalert2.all.min.js"></script>
    <script src="assets/js/vue2.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"><img src="assets/images/route.svg" width="50" alt="">CoordinateXY</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="house.php">Register <span class="sr-only">(current)</span></a>
                </li>
                <?php if ($_SESSION["group"] == "99"): ?>
                <li class="nav-item">
                    <a class="nav-link" href="user.php">User <span class="sr-only">(current)</span></a>
                </li>
                <?php endif;?>
                <li class="nav-item">
                    <a class="nav-link" href="map.php">Map</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="loader.php?page=logout">logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <br>
    <div class="container-fluid">
        <div class="text-left">
            <h6><span class="badge badge-dark"><?php echo $_SESSION["full_name"] . ' | ' . $_SESSION["department"]; ?>
                </span></h6>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div id="add_user">
                    <template v-if="!edit_status">
                        <h4>Add User</h4>
                        <form @submit.prevent="add_user">
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label>username : </label>
                                    <input required v-model="profile.username" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>first_name : </label>
                                    <input required v-model="profile.first_name" type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>last_name : </label>
                                    <input required v-model="profile.last_name" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label>department : </label>
                                    <input required v-model="profile.department" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>password : </label>
                                    <input required v-model="profile.password_hash" type="password"
                                        class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>confirm_password : </label>
                                    <div class="input-group">

                                        <input required v-model="confirm_password" type="password" class="form-control">
                                        <div class="input-group-append">
                                            <span v-if="profile.password_hash == '' &&  confirm_password == ''"
                                                class="input-group-text  bg-white">
                                                <i class="fas fa-exclamation-circle"></i>
                                            </span>
                                            <span v-else-if="profile.password_hash != confirm_password"
                                                class="input-group-text  bg-white">
                                                <i class="fas fa-times-circle"></i>
                                            </span>
                                            <span v-else class="input-group-text  bg-white">
                                                <i class="fas fa-check-circle"></i>
                                            </span>
                                        </div>

                                    </div>


                                </div>

                            </div>
                            <button class="btn btn-dark  btn-block" type="submit">Add</button>
                        </form>
                        <br>
                        Status : {{status}}
                        <br>
                        Message : {{result.message}}
                    </template>
                    <template v-else>
                        <h4>Edit User</h4>
                        <form @submit.prevent="edit_user">
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label>username : </label>
                                    <input readonly required v-model="profile.username" type="text"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>first_name : </label>
                                    <input required v-model="profile.first_name" type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>last_name : </label>
                                    <input required v-model="profile.last_name" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label>department : </label>
                                    <input required v-model="profile.department" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>password : </label>
                                    <input required v-model="profile.password_hash" type="password"
                                        class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>confirm_password : </label>
                                    <div class="input-group">

                                        <input required v-model="confirm_password" type="password" class="form-control">
                                        <div class="input-group-append">
                                            <span v-if="profile.password_hash == '' &&  confirm_password == ''"
                                                class="input-group-text  bg-white">
                                                <i class="fas fa-exclamation-circle"></i>
                                            </span>
                                            <span v-else-if="profile.password_hash != confirm_password"
                                                class="input-group-text  bg-white">
                                                <i class="fas fa-times-circle"></i>
                                            </span>
                                            <span v-else class="input-group-text  bg-white">
                                                <i class="fas fa-check-circle"></i>
                                            </span>
                                        </div>

                                    </div>


                                </div>

                            </div>
                            <button class="btn btn-dark  btn-block" type="submit">Update</button>
                            <button class="btn btn-dark  btn-block" v-on:click="edit_status = false">Cancel</button>
                        </form>
                        <br>
                        Status : {{status}}
                        <br>
                        Message : {{result.message}}
                    </template>
                </div>
            </div>
            <div class="col-md-8">
                <div id="list_users">
                    <div class="row">
                        <div class="col-md-8">
                            <h4>User List </h4>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Find : </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text  bg-white">
                                            <i class="fas fa-search"></i>
                                        </span>
                                    </div>
                                    <input v-model="find_me" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-sm table-borderless table-responsive">
                        <thead>
                            <tr class="text-white bg-dark" v-if="v_add_user.empty_profile()">
                                <td>></td>
                                <td colspan="11">
                                    <span class="text-white">waiting</span>
                                </td>
                            </tr>
                            <tr class="text-white bg-dark" v-else>
                                <td>></td>
                                <td>{{v_add_user.profile.username}}</td>
                                <td>{{v_add_user.profile.first_name}}</td>
                                <td>{{v_add_user.profile.last_name}}</td>
                                <td>{{v_add_user.profile.department}}</td>
                                <td>{{v_add_user.replace_char()}}</td>
                                <td colspan="6">
                                    <span class="text-white">preparing..</span>
                                </td>
                            </tr>
                            <tr>
                                <th>#</th>
                                <th>username</th>
                                <th>first_name</th>
                                <th>last_name</th>
                                <th>department</th>
                                <th>password_hash</th>
                                <th>group</th>
                                <th>time_created</th>
                                <th>status</th>
                                <th colspan="3">action</th>
                            </tr>

                        </thead>
                        <tbody>
                            <template v-if="find_me == '' && users.profile.length > 0">
                                <tr v-for="(item, index) in users.profile"
                                    v-if="index >= (pagination_me.cur_page * pagination_me.data_on_page) && index < ((pagination_me.cur_page + 1) * pagination_me.data_on_page)"
                                    :key="index">
                                    <td>{{index+1}}</td>
                                    <td>{{item.username}}</td>
                                    <td>{{item.first_name}}</td>
                                    <td>{{item.last_name}}</td>
                                    <td>{{item.department}}</td>
                                    <td>{{item.password_hash}}</td>
                                    <td>{{item.group}}</td>
                                    <td>{{item.time_created}}</td>
                                    <td>{{item.status}}</td>
                                    <td>
                                        <button v-on:click="edit_user(index)" class="btn btn-sm btn-dark">edit</button>
                                    </td>
                                    <td>
                                        <button v-on:click="activate_user(index)" class="btn btn-sm btn-dark">set
                                        </button>
                                    </td>
                                    <td>
                                        <button v-on:click="remove_user(index)"
                                            class="btn btn-sm btn-dark">remove</button>
                                    </td>
                                </tr>


                            </template>
                            <template v-else-if="find_me != '' && users.profile.length > 0">

                                <tr v-for="(item, index) in users.profile" v-if="item.username == find_me" :key="index">
                                    <td>{{index+1}}</td>
                                    <td>{{item.username}}</td>
                                    <td>{{item.first_name}}</td>
                                    <td>{{item.last_name}}</td>
                                    <td>{{item.department}}</td>
                                    <td>{{item.password_hash}}</td>
                                    <td>{{item.group}}</td>
                                    <td>{{item.time_created}}</td>
                                    <td>{{item.status}}</td>
                                    <td>
                                        <button v-on:click="edit_user(index)" class="btn btn-sm btn-dark">edit</button>
                                    </td>
                                    <td>
                                        <button v-on:click="activate_user(index)" class="btn btn-sm btn-dark">set
                                        </button>
                                    </td>
                                    <td>
                                        <button v-on:click="remove_user(index)"
                                            class="btn btn-sm btn-dark">remove</button>
                                    </td>
                                </tr>


                            </template>
                            <template v-else>
                                <tr>
                                    <td colspan="12">empty</td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                    <template v-if="users.profile.length > 0 && (find_me == '')">
                        Per Page: {{pagination_me.data_on_page}}<br>
                        Data: {{pagination_me.count_data}}<br>
                        Page : {{pagination_me.count_page}}<br>
                        Cur Page: {{pagination_me.cur_page}}
                        <nav>
                            <ul class="pagination justify-content-center">
                                <li class="page-item">
                                    <a class="page-link" v-on:click="pagination_me.cur_page = 0">Previous</a>
                                </li>
                                <template v-for="(item, index) in pagination_me.count_page" :key="index">
                                    <li
                                        v-bind:class="[pagination_me.page_style, index == pagination_me.cur_page ? pagination_me.active_page_style : '']">
                                        <a class="page-link" v-on:click="pagination_me.cur_page = index">{{index+1}}</a>
                                    </li>
                                </template>
                                <li class="page-item">
                                    <a class="page-link"
                                        v-on:click="pagination_me.cur_page = pagination_me.count_page - 1">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </template>

                </div>
            </div>
        </div>
    </div>




</body>
<script src="front/constant.js"></script>
<script src="front/User_manager/add_user.js"></script>
<script src="front/User_manager/list_users.js"></script>

</html>