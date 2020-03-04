v_map = new Vue({
    el: '#app_map',
    data: {
        api_url: BASE_URL + 'loader.php?page=get_house',
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