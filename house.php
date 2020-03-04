<?php session_start();
if (isset($_SESSION["login"]) != "pass") {
    header("Location: https://getxy2020.herokuapp.com/");
}
?>
<!DOCTYPE html>
<html lang="en">

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

                <div id="app_address">
                    <template v-if="!edit_status">
                        <h4>Register House</h4>
                        <form id="form_001" @submit.prevent="save_func">
                            <div class="form-group">
                                <label> จังหวัด :</label>
                                <select required @change="reset_value_func('p')" v-model="sel_province"
                                    class="form-control">
                                    <option v-for="item in province" v-bind:value="item.PROVINCE_ID">
                                        {{item.PROVINCE_NAME}}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label> อำเภอ :</label>
                                <select required @change="reset_value_func('a')" v-model="sel_amphur"
                                    class="form-control">
                                    <option v-for="item in amphur" v-if="sel_province == item.PROVINCE_ID"
                                        v-bind:value="item.AMPHUR_ID"> {{item.AMPHUR_NAME}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label> ตำบล :</label>
                                <select required v-model="sel_district" class="form-control">
                                    <option v-for="item in district" v-if="sel_amphur == item.AMPHUR_ID"
                                        v-bind:value="item.DISTRICT_CODE"> {{item.DISTRICT_NAME}}</option>
                                </select>
                            </div>


                            <div class="form-group" v-for="(item, index) in zipcode" :key="index"
                                v-if="item.DISTRICT_CODE == sel_district">
                                <label> zip_code :</label>
                                <input readonly v-model="item.ZIPCODE" class="form-control" type="text">
                            </div>
                            <div class="form-group">
                                <label> หมู่ที่ :</label>
                                <input required v-model="mo" class="form-control" type="text">
                            </div>




                            <div class="form-group">
                                <label> บ้านเลขที่ :</label>
                                <textarea v-model="address" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label> hid :</label>
                                <input v-model="hid" class="form-control" type="text">
                            </div>
                            <div class="form-group">
                                <label> X (longitude) :</label>
                                <input v-model="x" class="form-control" type="text">
                            </div>
                            <div class="form-group">
                                <label> Y (latitude) :</label>
                                <input v-model="y" class="form-control" type="text">
                            </div>


                        </form>
                        <button class="btn btn-danger btn-block" v-on:click="get_location_xy">get</button>
                        <button form="form_001" class="btn btn-dark btn-block" type="submit">save</button>
                    </template>
                    <template v-else>
                        <h4>Edit House</h4>
                        <form id="form_002" @submit.prevent="edit_func">
                            <div class="form-group">
                                <label> จังหวัด :</label>
                                <select required @change="reset_value_func('p')" v-model="sel_province"
                                    class="form-control">
                                    <option v-for="item in province" v-bind:value="item.PROVINCE_ID">
                                        {{item.PROVINCE_NAME}}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label> อำเภอ :</label>
                                <select required @change="reset_value_func('a')" v-model="sel_amphur"
                                    class="form-control">
                                    <option v-for="item in amphur" v-if="sel_province == item.PROVINCE_ID"
                                        v-bind:value="item.AMPHUR_ID"> {{item.AMPHUR_NAME}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label> ตำบล :</label>
                                <select required v-model="sel_district" class="form-control">
                                    <option v-for="item in district" v-if="sel_amphur == item.AMPHUR_ID"
                                        v-bind:value="item.DISTRICT_CODE"> {{item.DISTRICT_NAME}}</option>
                                </select>
                            </div>


                            <div class="form-group" v-for="(item, index) in zipcode" :key="index"
                                v-if="item.DISTRICT_CODE == sel_district">
                                <label> zip_code :</label>
                                <input readonly v-model="item.ZIPCODE" class="form-control" type="text">
                            </div>
                            <div class="form-group">
                                <label> หมู่ที่ :</label>
                                <input required v-model="mo" class="form-control" type="text">
                            </div>




                            <div class="form-group">
                                <label> บ้านเลขที่ :</label>
                                <textarea v-model="address" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label> hid :</label>
                                <input v-model="hid" class="form-control" type="text">
                            </div>
                            <div class="form-group">
                                <label> X (longitude) :</label>
                                <input v-model="x" class="form-control" type="text">
                            </div>
                            <div class="form-group">
                                <label> Y (latitude) :</label>
                                <input v-model="y" class="form-control" type="text">
                            </div>


                        </form>
                        <button class="btn btn-danger btn-block" v-on:click="get_location_xy">get</button>
                        <button form="form_002" class="btn btn-dark btn-block" type="submit">update</button>
                        <button class="btn btn-light btn-block" v-on:click="claer_profile">cancel</button>
                    </template>
                    <br><br>
                </div>

            </div>
            <div class="col-md-8">

                <div id="list_data">
                    <div class="row">
                        <div class="col-md-8">
                            <h4>House List </h4>
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
                            <template v-if="lst_dat.message.length > 0">
                                <tr>
                                    <th>#</th>
                                    <th v-for="(item, index) in header_func()" v-if="header_set[item]">
                                        {{header_set[item]}}
                                    </th>
                                    <th colspan="3">action</th>
                                </tr>
                            </template>
                        </thead>
                        <tbody>
                            <template v-if="find_me == '' && lst_dat.message.length > 0">
                                <tr v-for="(item, index) in lst_dat.message"
                                    v-if="index >= (pagination_me.cur_page * pagination_me.data_on_page) && index < ((pagination_me.cur_page + 1) * pagination_me.data_on_page)"
                                    :key="index">
                                    <td>{{index+1}}</td>
                                    <td v-for="(sub_item, sub_index) in header_func()" v-if="header_set[sub_item]">
                                        {{item[sub_item]}}</td>
                                    <td>
                                        <button v-on:click="edit_data(index)" class="btn btn-sm btn-dark">edit</button>
                                    </td>
                                    <td>
                                        <button v-on:click="remove_data(index)"
                                            class="btn btn-sm btn-dark">remove</button>
                                    </td>
                                </tr>


                            </template>
                            <template v-else-if="find_me != '' && lst_dat.message.length > 0">

                                <tr v-for="(item, index) in lst_dat.message" v-if="item.hid == find_me" :key="index">
                                    <td>{{index+1}}</td>
                                    <td v-for="(sub_item, sub_index) in header_func()" v-if="header_set[sub_item]">
                                        {{item[sub_item]}}</td>
                                    <td>
                                        <button v-on:click="edit_data(index)" class="btn btn-sm btn-dark">edit</button>
                                    </td>
                                    <td>
                                        <button v-on:click="remove_data(index)"
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
                    <template v-if="lst_dat.message.length > 0 && (find_me == '')">
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
<script src="front/House_register/list_data.js"></script>
<script src="front/House_register/get_address.js"></script>
<script>
v_get_address.explorer = '<?php echo $_SESSION["full_name"]; ?>'
</script>

</html>