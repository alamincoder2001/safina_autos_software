<style>
  .v-select {
    margin-bottom: 5px;
    width: 250px;
  }

  .v-select .dropdown-toggle {
    padding: 0px;
  }

  .v-select input[type=search],
  .v-select input[type=search]:focus {
    margin: 0px;
  }

  .v-select .selected-tag {
    margin: 0px;
  }

  .skiptranslate.goog-te-gadget {
    margin-right: 10px;
    width: 150px;
    color: #fff;
    height: 30px;
    margin-top: 7px;
  }

  .translated-ltr .goog-te-banner {
    display: none !important;
    z-index: -111111;
  }

  div#navbar {
    z-index: 9999999999;
  }

  .translated-ltr .main-container {
    padding-top: 0;
  }

  a.goog-logo-link {
    z-index: -999999;
    display: none;
  }

  .skiptranslate .goog-te-gadget span a img {
    display: none !important;
  }
</style>




<div id="salesInvoiceReport">
  <div class="row" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
    <div class="col-xs-6">
      <div class="form-group" style="margin-top:10px;">
        <label class="col-sm-2 control-label no-padding-right"> Invoice no </label>
        <label class="col-sm-1 control-label no-padding-right"> : </label>
        <div class="col-sm-3">
          <v-select v-bind:options="invoices" label="invoice_text" v-model="selectedInvoice" v-on:input="viewInvoice" placeholder="Select Invoice"></v-select>
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-2">
          <input type="button" class="btn btn-primary" value="Show Report" v-on:click="viewInvoice" style="margin-top:0px;width:150px;display: none;">
        </div>
      </div>
    </div>
    <div class="col-xs-6">
      <div id="google_translate_element"></div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <br>
      <sales-invoice v-bind:sales_id="selectedInvoice.SaleMaster_SlNo" v-if="showInvoice"></sales-invoice>
    </div>
  </div>


</div>




<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/components/salesInvoice.js"></script>
<!-- <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'bn', includedLanguages: 'en,bn'
            }, 'google_translate_element');
        }
    </script> -->

<!-- <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> -->
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script type="text/javascript">
  function googleTranslateElementInit() {
    // setCookie('googtrans', '/en/bn', 1);
    new google.translate.TranslateElement({
      pageLanguage: 'en',
      // layout: google.translate.TranslateElement.InlineLayout
    }, 'google_translate_element');
  }

  function setCookie(key, value, expiry) {
    var expires = new Date();
    expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
    document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
  }
</script>


</script>





<script>
  Vue.component('v-select', VueSelect.VueSelect);
  new Vue({
    el: '#salesInvoiceReport',
    data() {
      return {
        invoices: [],
        selectedInvoice: null,
        showInvoice: false
      }
    },
    created() {
      this.getSales();
    },
    methods: {
      getSales() {
        axios.get("/get_sales").then(res => {
          this.invoices = res.data.sales;
        })
      },
      async viewInvoice() {
        this.showInvoice = false;
        await new Promise(r => setTimeout(r, 500));
        this.showInvoice = true;
      }
    }
  })
</script>