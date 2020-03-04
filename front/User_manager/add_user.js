v_add_user = new Vue({
    el: '#add_user',
    data: {
        profile: {
            username: '',
            first_name: '',
            last_name: '',
            department: '',
            password_hash: '',
            group: '',
            time_created: '',
            status: '',
        },
        confirm_password: '',
        status: '',
        result: '',
        edit_status: false
    },
    methods: {
        edit_user: function () {
            if (this.password_confirm_match()) {
                Swal.fire({
                    title: 'Confirm to update?',
                    text: "Once confirmed, you will not be able to cancel this!",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: 'black',
                    confirmButtonText: 'confirm',
                    cancelButtonText: 'cancel'
                }).then((result) => {
                    if (result.value) {
                        axios.post(BASE_URL+'loader.php?page=edit_user', this.profile)
                            .then(response => {
                                console.log(response)
                                this.status = response.status
                                this.result = response.data
                                this.claer_profile()
                                v_list_users.up()
                                this.edit_status = false
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
                });

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    confirmButtonColor: 'black',
                })
            }
        },
        add_user: function () {
            if (this.password_confirm_match()) {
                Swal.fire({
                    title: 'Confirm to register?',
                    text: "Once confirmed, you will not be able to cancel this!",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: 'black',
                    confirmButtonText: 'confirm',
                    cancelButtonText: 'cancel'
                }).then((result) => {
                    if (result.value) {
                        axios.post(BASE_URL+'loader.php?page=add_user', this.profile)
                            .then(response => {
                                console.log(response)
                                this.status = response.status
                                this.result = response.data
                                if (this.result.message != 'exist_user') {
                                    this.claer_profile()
                                    v_list_users.up()
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: this.result.profile,
                                        confirmButtonColor: 'black',
                                    })
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
                });

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    confirmButtonColor: 'black',
                })
            }
        },
        password_confirm_match: function () {
            if (this.profile.password_hash == this.confirm_password) {
                return true
            } else {
                return false
            }
        },
        replace_char: function () {
            let str = '';
            for (let i = 0; i < this.profile.password_hash.length; i++) {
                str += '*'
            }
            return str
        },
        claer_profile: function () {
            this.profile.username = ''
            this.profile.first_name = ''
            this.profile.last_name = ''
            this.profile.department = ''
            this.profile.password_hash = ''
            this.confirm_password = ''
        },
        empty_profile: function () {
            if (
                this.profile.username == '' &&
                this.profile.first_name == '' &&
                this.profile.last_name == '' &&
                this.profile.department == '' &&
                this.profile.password_hash == ''
            ) {
                return true
            } else {
                return false
            }
        }
    }
})

