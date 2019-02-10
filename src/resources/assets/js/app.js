require('./bootstrap');

window.app = new Vue({
  el: '#app',

  data() {
    const firstLoadUrl = window.location.origin + '/' + document.getElementById('app').dataset.uri;

    return {
      search: '',
      firstLoad: true,
      loadingMails: false,
      loadingMail: false,
      refreshData: {
        next_page_url: firstLoadUrl
      },
      mails: {
        next_page_url: firstLoadUrl
      },
      currentMail: null
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

    refresh() {
      let vm = this;

      vm.mails = vm.refreshData;
      vm.loadMails();
    },

    loadMails() {
      let vm = this;

      vm.loadingMails = true;
      axios.get(vm.mails.next_page_url)
           .then(response => {
             let data = response.data;

             if (data.success) {
               let mails = vm.mails.data || [];

               _.each(data.data.data, (mail) => {
                 mails.push(mail);
               });

               vm.mails = data.data;
               vm.mails.data = mails;

               if (vm.mails.data && !vm.currentMail) {
                 vm.currentMail = vm.mails.data[0];
               }
             } else {
               console.error('Something went wrong!');
             }

             vm.loadingMails = false;
             vm.firstLoad = false;
           })
           .catch(e => {
             vm.loadingMails = false;
             vm.firstLoad = false;

             console.log(e);
           });
    },

    view(mail) {
      this.loadingMail = true;
      this.currentMail = mail;
    }
  },

  computed: {
    filteredMails() {
      const search = this.search.toLowerCase().trim();

      if (!search) {
        return this.mails.data;
      }

      return this.mails.data.filter((mail) => {
        const searchObject= {
          formattedFrom: mail.formattedFrom || '',
          formattedTo: mail.formattedTo || '',
          subject: mail.subject || '',
          formattedDate: mail.formattedDate || '',
          formattedCc: mail.formattedCc || '',
          formattedBcc: mail.formattedBcc || '',
        };

        return searchObject.formattedFrom.toLowerCase().includes(search) ||
          searchObject.formattedTo.toLowerCase().includes(search) ||
          searchObject.subject.toLowerCase().includes(search) ||
          searchObject.formattedDate.toLowerCase().includes(search) ||
          searchObject.formattedCc.toLowerCase().includes(search) ||
          searchObject.formattedBcc.toLowerCase().includes(search);
      });
    }
  }
})
;