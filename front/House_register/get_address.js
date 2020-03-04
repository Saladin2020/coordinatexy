v_get_address = new Vue({
    el: '#app_address',
    data: {
        edit_status: false,
        province: [],
        amphur: [],
        district: [],
        zipcode: [],
        sel_province: '',
        sel_amphur: '',
        sel_district: '',
        sel_zipcode: '',
        mo: '',
        hid: '',
        address: '',
        x: 0,
        y: 0,
        id: -1,
        explorer: '',
        error_msg: ''
    },
    mounted: function () {
        axios.get('http://49.229.25.51/api_coordinatexy/index.php/v1/get_province')
            .then(response => {
                this.province = response.data.message
            })
            .catch(function (error) {
                console.log(error);
            })
        axios.get('http://49.229.25.51/api_coordinatexy/index.php/v1/get_amphur')
            .then(response => {
                this.amphur = response.data.message
            })
            .catch(function (error) {
                console.log(error);
            })
        axios.get('http://49.229.25.51/api_coordinatexy/index.php/v1/get_district')
            .then(response => {
                this.district = response.data.message
            })
            .catch(function (error) {
                console.log(error);
            })
        axios.get('http://49.229.25.51/api_coordinatexy/index.php/v1/get_zipcode')
            .then(response => {
                this.zipcode = response.data.message
            })
            .catch(function (error) {
                console.log(error);
            })

    },
    methods: {
        reset_value_func: function (name) {
            switch (name) {
                case 'p':
                    this.sel_amphur = ''
                    this.sel_district = ''
                    this.sel_zipcode = ''
                    break
                case 'a':
                    this.sel_district = ''
                    this.sel_zipcode = ''
                    break
                default:
                    break
            }

        },
        district_func: function (district) {
            let index = -1
            for (let i = 0; i < this.district.length; i++) {
                index++
                if (this.district[i].DISTRICT_CODE == district) {
                    break
                }
            }
            return this.district[index].DISTRICT_NAME
        },
        amphur_func: function (amphur) {
            let index = -1
            for (let i = 0; i < this.amphur.length; i++) {
                index++
                if (this.amphur[i].AMPHUR_ID == amphur) {
                    break
                }
            }
            return this.amphur[index].AMPHUR_NAME
        },
        province_func: function (province) {
            let index = -1
            for (let i = 0; i < this.amphur.length; i++) {
                index++
                if (this.province[i].PROVINCE_ID == province) {
                    break
                }
            }
            return this.province[index].PROVINCE_NAME
        },

        claer_profile: function () {
            this.edit_status = false
            this.sel_province = ''
            this.sel_amphur = ''
            this.sel_district = ''
            this.sel_zipcode = ''
            this.mo = ''
            this.hid = ''
            this.address = ''
            this.x = 0
            this.y = 0
            this.id = -1
        },
        save_func: function () {
            console.log(this.district_func(this.sel_district))
            let post_data = {
                hid: this.hid,
                haddress: this.address,
                hmo: this.mo,
                hdistrict_number: this.sel_district,
                hamphur_number: this.sel_amphur,
                hprovince_number: this.sel_province,
                hdistrict_name: this.district_func(this.sel_district),
                hamphur_name: this.amphur_func(this.sel_amphur),
                hprovince_name: this.province_func(this.sel_province),
                x: this.x,
                y: this.y,
                explorer: this.explorer 
            }

            Swal.fire({
                title: 'Confirm to save?',
                text: "Once confirmed, you will not be able to cancel this!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: 'black',
                confirmButtonText: 'confirm',
                cancelButtonText: 'cancel'
            }).then((result) => {
                if (result.value) {
                    axios.post(BASE_URL + 'api_coordinatexy/index.php/v1/save', post_data)
                        .then(response => {
                            result = response.data.message
                            if (result != 'data_exist') {
                                this.claer_profile()
                                v_list_data.up()
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: result,
                                    confirmButtonColor: 'black',
                                })
                            }

                        })
                        .catch(function (error) {
                            console.log(error);
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


        edit_func: function () {
            console.log(this.district_func(this.sel_district))
            let post_data = {
                id: this.id,
                hid: this.hid,
                haddress: this.address,
                hmo: this.mo,
                hdistrict_number: this.sel_district,
                hamphur_number: this.sel_amphur,
                hprovince_number: this.sel_province,
                hdistrict_name: this.district_func(this.sel_district),
                hamphur_name: this.amphur_func(this.sel_amphur),
                hprovince_name: this.province_func(this.sel_province),
                x: this.x,
                y: this.y,
                explorer: this.explorer 
            }

            Swal.fire({
                title: 'Confirm to save?',
                text: "Once confirmed, you will not be able to cancel this!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: 'black',
                confirmButtonText: 'confirm',
                cancelButtonText: 'cancel'
            }).then((result) => {
                if (result.value) {
                    axios.post(BASE_URL + 'api_coordinatexy/index.php/v1/ed_house', post_data)
                        .then(response => {
                            result = response.data.message
                            this.claer_profile()
                            v_list_data.up()
                        })
                        .catch(function (error) {
                            console.log(error);
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
        get_location_xy: function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(this.position)
            } else {
                this.error_msg = "Geolocation is not supported by this browser."
            }


        },
        position: function (p) {
            this.x = p.coords.longitude
            this.y = p.coords.latitude
        }
    },
})