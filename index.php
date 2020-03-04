<?php session_start();
if (isset($_SESSION["login"]) == "pass"){
    header("Location: https://getxy2020.herokuapp.com/house.php");
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
</head>

<body style="padding-top:3rem;background-color: #adb5bd;">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col col-lg-4">
                <div id="app_login">
                    <div class="card">
                        <div class="card-body">
                            <form @submit.prevent="login_func">
                                <div class="text-center">
                                <img src="assets/images/route.svg" width="50" alt=""><span class="h4">CoordinateXY</span>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label>User : </label>
                                    <input v-model="user_name_input" required class="form-control" type="text">
                                </div>
                                <label>Password : </label>
                                <div class="form-group">
                                    <input v-model="password_input" required class="form-control" type="password">
                                </div>
                                <button class="btn btn-dark btn-block">Login</button>
                                <br><span v-if="result == 'incorrect'" class="text-danger">{{result}}</span>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>
<script src="front/constant.js"></script>
<script src="front/Login/login.js"></script>


</html>