<script src="{{asset('frontend')}}/js/jquery.min.js"></script>
<script src="{{asset('frontend')}}/js/jquery-ui.min.js"></script>
<script src="{{asset('frontend')}}/js/popper.min.js"></script>
<script src="{{asset('frontend')}}/js/bootstrap.min.js"></script>
<script src="{{asset('frontend')}}/js/wow.min.js"></script>
<script src="{{asset('frontend')}}/js/owl.carousel.min.js"></script>
<script src="{{asset('frontend')}}/js/jquery.parallax-scroll.js"></script>
<script src="{{asset('frontend')}}/js/select2.min.js"></script>
<script src="{{asset('frontend')}}/js/bootstrap-select.js"></script>
<script src="{{asset('frontend')}}/js/jquery.mousewheel.min.js"></script>
<script src="{{asset('frontend')}}/js/jquery.mCustomScrollbar.js"></script>
<script src="{{asset('frontend')}}/js/smoothproducts.min.js"></script>
<script src="{{asset('frontend')}}/js/jQuery.print.min.js"></script>
<script src="{{ asset('frontend/js/intlTelInput.js') }}"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/i18n/jquery-ui-i18n.min.js">
</script>

<script  src="/frontend/js/vue@3.2.40/dist/vue.global.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="{{asset('frontend')}}/js/script-{{ locale() }}.js"></script>
<script src="{{asset('frontend')}}/js/custom-en.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.all.min.js"></script>
<script src="{{asset('frontend')}}/js/actions.js"></script>
<script src="https://momentjs.com/downloads/moment.js"></script>

<script>
  if ($("#mobile").length) {
      var input = document.querySelector("#mobile");
   iti=window.intlTelInput(input, {
      utilsScript: "{{ asset('frontend/js/utils.js') }}",
      hiddenInput: "mobile",
      autoHideDialCode: true,
      separateDialCode: true,
      initialCountry: "kw",
      });

      input.addEventListener("countrychange", function () {
        $('#mobile_country').val(iti.getSelectedCountryData().iso2);
      });
  }



  function changeItemData(selector,show = false){
      selector = $(selector);
      let option = selector.find(":selected");
      let data = JSON.parse(option.attr('data-item'));
      let price_data = selector.parent().parent().find('.price_data');
      let block = price_data.find('.block');
      let price = price_data.find('.the_price');


      @if(canOrderStatus())
      let url = "{{ route('frontend.packages.subscribeForm','::price_id') }}";
      url = url.replace('::price_id', data.id);
      @endif

      let action = show ? $('#addto-cart') : price_data.find('.addto-cart');

      block.text('').append(`
          <h4 class="inner-title">{{__('Duration')}}: ${data.subscribe_duration_desc}</h4>
      `);
      price.text('').append(data.active_price.price_html);

      @if(canOrderStatus())
      action.attr('href',url);
      @endif
      action.show();
      price_data.show();


      let subscribe_start_date = option.data('area');
      if(!subscribe_start_date){
        subscribe_start_date = moment().add(1,'days').format("YYYY-MM-DD");
      }

      if(moment(subscribe_start_date) < moment(selector.parents('.product-block').find('input[name="start"]').val())){
        subscribe_start_date = moment(selector.parents('.product-block').find('input[name="start"]').val()).format("YYYY-MM-DD");
      }

      selector.parents('.product-block').find('input[name="start"]').attr('min',subscribe_start_date)
      selector.parents('.product-block').find('input[name="start"]').attr('value',subscribe_start_date)
      $('.addto-cart').attr('href',url+'?start='+moment(subscribe_start_date).format("YYYY-MM-DD"))
  }


  $(".select2_package").select2({
      width: '300px',
      height: '25px',
      placeholder: '{{__('select Duration')}}..'
      //data: data
  });
</script>
@stack('js')
