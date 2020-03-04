v_list_users = new Vue({
    el: "#list_users",
    data: {
        users: [],
        pagination_me: {
            page_style: 'page-item',
            active_page_style: 'active',
            data_on_page: 5,
            count_data: 0,
            count_page: 0,
            cur_page: 0
        },
        find_me: ''
    },
    mounted() {
        axios.get(BASE_URL + 'coordinatexy/loader.php?page=get_users')
            .then(response => {
                this.users = response.data
                this.pagination_me_func()
            })
            .catch(function (error) {
                console.log(error);
            })
    },
    methods: {
        pagination_me_func: function () {
            this.pagination_me.count_data = this.users.profile.length
            this.pagination_me.count_page = Math.ceil(this.users.profile.length / this.pagination_me.data_on_page)
            this.pagination_me.cur_page = 0
        },
        up: function () {
            axios.get(BASE_URL + 'loader.php?page=get_users')
                .then(response => {
                    this.users = response.data
                    this.pagination_me_func()
                })
                .catch(function (error) {
                    console.log(error);
                })
        },
        edit_user: function (user) {
            v_add_user.edit_status = true
            v_add_user.profile.username = this.users.profile[user].username
            v_add_user.profile.first_name = this.users.profile[user].first_name
            v_add_user.profile.last_name = this.users.profile[user].last_name
            v_add_user.profile.department = this.users.profile[user].department
        },
        activate_user: function (user) {
            console.log(this.users.profile[user].username)
            Swal.fire({
                title: 'Confirm to activate?',
                text: "Once confirmed, you will not be able to cancel this!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: 'black',
                confirmButtonText: 'confirm',
                cancelButtonText: 'cancel'
            }).then((result) => {
                if (result.value) {
                    data_post = {
                        username: this.users.profile[user].username
                    }
                    axios.post(BASE_URL + 'loader.php?page=activate_user', data_post)
                        .then(response => {
                            v_add_user.status = response.status
                            v_add_user.result = response.data
                            this.up()
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
            })
        },
        remove_user: function (user) {
            console.log(this.users.profile[user].username)
            Swal.fire({
                title: 'Confirm to remove?',
                text: "Once confirmed, you will not be able to cancel this!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: 'black',
                confirmButtonText: 'confirm',
                cancelButtonText: 'cancel'
            }).then((result) => {
                if (result.value) {
                    data_post = {
                        username: this.users.profile[user].username
                    }
                    axios.post(BASE_URL + 'loader.php?page=remove_user', data_post)
                        .then(response => {
                            v_add_user.status = response.status
                            v_add_user.result = response.data
                            this.up()
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
            })
        }
    }

})
