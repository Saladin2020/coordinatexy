v_map = new Vue({
    el: '#app_map',
    data: {
        api_url: BASE_URL + 'api_coordinatexy/index.php/v1/get_house',
        position: []
    },
    mounted() {
        axios.get(this.api_url)
            .then(response => {
                this.position = response.data.message
            })
            .catch(function (error) {
                console.log(error);
            })
    }
})