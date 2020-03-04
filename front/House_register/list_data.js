v_list_data = new Vue({
    el: "#list_data",
    data: {
        api_url: BASE_URL + 'api_coordinatexy/index.php/v1/get_house',
        api_url_remove: BASE_URL + 'api_coordinatexy/index.php/v1/rm_house',
        header_set: {
            'id': false,
            'hid': 'เลขทะเบียนบ้าน',
            'haddress': 'ที่อยู่',
            'hmo': 'หมู่ที่',
            'hdistrict_number': false,
            'hamphur_number': false,
            'hprovince_number': false,
            'hdistrict_name': 'ตำบล',
            'hamphur_name': 'อำเภอ',
            'hprovince_name': 'จังหวัด',
            'x': 'x',
            'y': 'y'
        },
        lst_dat: [],
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
        axios.get(this.api_url)
            .then(response => {
                this.lst_dat = response.data
                this.pagination_me_func()
            })
            .catch(function (error) {
                console.log(error);
            })
    },
    methods: {
        header_func: function () {
            return Object.keys(this.lst_dat.message[0]);
        },
        pagination_me_func: function () {
            this.pagination_me.count_data = this.lst_dat.message.length
            this.pagination_me.count_page = Math.ceil(this.lst_dat.message.length / this.pagination_me.data_on_page)
            this.pagination_me.cur_page = 0
        },
        up: function () {
            this.lst_dat = []
            axios.get(this.api_url)
                .then(response => {
                    this.lst_dat = response.data
                    this.pagination_me_func()
                })
                .catch(function (error) {
                    console.log(error);
                })
        },
        edit_data: function (index) {
            v_get_address.edit_status = true
            v_get_address.id = this.lst_dat.message[index].id
            v_get_address.sel_province = this.lst_dat.message[index].hprovince_number
            v_get_address.sel_amphur = this.lst_dat.message[index].hamphur_number
            v_get_address.sel_district = this.lst_dat.message[index].hdistrict_number
            v_get_address.mo = this.lst_dat.message[index].hmo
            v_get_address.hid = this.lst_dat.message[index].hid
            v_get_address.address = this.lst_dat.message[index].haddress
            v_get_address.x = this.lst_dat.message[index].x
            v_get_address.y = this.lst_dat.message[index].y

        },
        remove_data: function (index) {
            console.log(this.lst_dat.message[index].id)
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
                        id: this.lst_dat.message[index].id
                    }
                    axios.post(this.api_url_remove, data_post)
                        .then(response => {
                            console.log(response.data.message)
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
