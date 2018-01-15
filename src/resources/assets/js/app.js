require('./bootstrap');

const app = new Vue({
        el: '#app',

        data() {
            return {
                loading: false,
                mails: {
                    next_page_url: window.location.origin + '/mail-viewer'
                },
            };
        },

        mounted() {
            this.init();
        },

        methods: {
            init() {
                let vm = this;

                vm.loadMails();
            },

            loadMails() {
                let vm = this;

                vm.loading = true;
                axios.get(vm.mails.next_page_url)
                    .then(response => {
                        let data = response.data;

                        if (data.success) {
                            vm.mails = data.data;
                        } else {
                            console.error('Something went wrong!');
                        }

                        vm.loading = false;
                    })
                    .catch(e => {
                        vm.loading = false;

                        console.log(e);
                    });
            }
        },


    })
;