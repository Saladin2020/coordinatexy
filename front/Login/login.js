v_login = new Vue({
    el: '#app_login',
    data: {
        user_name_input: '',
        password_input: '',
        result: []
    },
    methods: {
        login_func: function () {
            post_data = {
                username: this.user_name_input,
                password: this.password_input
            }
            axios.post(BASE_URL + 'loader.php?page=login', post_data)
                .then(response => {
                    console.log(response)
                    if (response.data.profile == "enter") {
                        location.reload()
                    } else {
                        this.result = response.data.profile
                    }

                })
                .catch(error => {
                    this.result = error
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: error,
                        confirmButtonColor: 'black',
                    })
                })
        }
    },
})