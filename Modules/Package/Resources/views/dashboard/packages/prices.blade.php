@push('styles')
<style>
    .inline-selector {
        display: inline !important;
        padding:0px 12px;
        margin: 5px 18px;
    }

    .input-xsmall {
        width: 88px !important;
        margin: 4px 9px;
    }

    .notee {
        padding: 20px 0px;
    }

    .price_item {
        padding: 5px;
        border: 1px solid #d5d5d5;
        margin-bottom: 10px;
    }

    .inline-selector-label {
        margin: 0px 3px;
    }

    .inline-selector-label-actions {
        margin: 0px 28px;
    }

    .inline-selector-label-actions i{
        margin: 0px 6px;
        cursor: pointer;
    }

    .inline-selector-label-actions .fa-plus{
        color: rgb(63, 198, 211);
    }

    .inline-selector-label-actions .fa-remove{
        color: rgb(244, 67, 54);
    }

    .inline-selector-label-actions .active{
        cursor: pointer;
    }

    .inline-selector-label-actions .deactive{
        color: rgb(213 213 213);
        cursor: not-allowed;
    }

</style>
@endpush

<div class="col-lg-12">
    <div class="form-group">
        <input step="0.01" type="number" step=".01" class="form-control input-larg inline-selector" v-model="price" placeholder="@lang("price")"/>
        <input type="number" step="1" class="form-control input-larg inline-selector" v-model="same_pricerenew_times" placeholder="@lang("Max Renew With Same Price")"/>
        <input type="number" step="1" class="form-control input-larg inline-selector" v-model="max_puse_days" placeholder="@lang("Max Pause days")"/>
        <input step="0.00" type="number" step=".01" class="form-control input-larg inline-selector" v-model="offer_percentage" placeholder="@lang("Offer Percentage")"/>
        <input type="date" class="form-control input-larg inline-selector" v-model="start_offer_date" placeholder="@lang("Offer start date")"/>
        <input type="date" class="form-control input-larg inline-selector" v-model="end_offer_date" placeholder="@lang("Offer end date")"/>
        <input type="number" class="form-control input-larg inline-selector" v-model="days_count" placeholder="@lang("Days Count")"/>

        @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
            <input type="text" class="form-control input-larg inline-selector" v-model="subscribe_duration_desc['{{$code}}']" placeholder="@lang("Description") - {{$code}}"/>
        @endforeach
    </div>
</div>
<br>
<div class="col-lg-12">
    <button @click="addPrice()"  :class="`btn btn-sm blue ${price ? 'active' : 'deactive'}`" title="Add" style="margin: 0px 6px;">
        <i class="fa fa-plus"></i>
    </button>
</div>
<br>
<div>
    <div class="portlet-body">
        <div class="row" style="margin: 0px;">

            <div class="col-lg-12 notee" v-if="package_prices.length">
                <div v-for="priceItem in package_prices" :key="priceItem.key" class="price_item">
                    <div class="form-group">
                        <input :data-name="`package_prices.${priceItem.id}.action`" type="hidden" :name="`package_prices[${priceItem.id}][action]`" v-model="priceItem.action"/>
                        <input :data-name="`package_prices.${priceItem.id}.id`" type="hidden" :name="`package_prices[${priceItem.id}][id]`" v-model="priceItem.id"/>
                        <input :data-name="`package_prices.${priceItem.id}.price`" step="0.01" type="number" :name="`package_prices[${priceItem.id}][price]`" step=".01" class="form-control input-small inline-selector" v-model="priceItem.price" placeholder="@lang("price")"/>
                        <input :data-name="`package_prices.${priceItem.id}.same_pricerenew_times`" type="number" :name="`package_prices[${priceItem.id}][same_pricerenew_times]`" step="1" class="form-control input-small inline-selector" v-model="priceItem.same_pricerenew_times" placeholder="@lang("Max Renew With Same Price")"/>
                        <input :data-name="`package_prices.${priceItem.id}.max_puse_days`" type="number" :name="`package_prices[${priceItem.id}][max_puse_days]`" step="1" class="form-control input-small inline-selector" v-model="priceItem.max_puse_days" placeholder="@lang("Max Pause days")"/>
                        <input :data-name="`package_prices.${priceItem.id}.offer_percentage`" step="0.00" type="number" :name="`package_prices[${priceItem.id}][offer_percentage]`" step=".01" class="form-control input-small inline-selector" v-model="priceItem.offer_percentage" placeholder="@lang("Offer Percentage")"/>
                        <input :data-name="`package_prices.${priceItem.id}.start_offer_date`" type="date" :name="`package_prices[${priceItem.id}][start_offer_date]`" class="form-control input-small inline-selector" v-model="priceItem.start_offer_date" placeholder="@lang("Offer start date")"/>
                        <input :data-name="`package_prices.${priceItem.id}.end_offer_date`" type="date" :name="`package_prices[${priceItem.id}][end_offer_date]`" class="form-control input-small inline-selector" v-model="priceItem.end_offer_date" placeholder="@lang("Offer end date")"/>
                        <input :data-name="`package_prices.${priceItem.id}.days_count`" type="number" :name="`package_prices[${priceItem.id}][days_count]`" class="form-control input-small inline-selector" v-model="priceItem.days_count" placeholder="@lang("Days Count")"/>

                        @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
                            <input type="text"
                                :data-name="`package_prices.${priceItem.id}.subscribe_duration_desc.{{$code}}`"
                                :name="`package_prices[${priceItem.id}][subscribe_duration_desc][{{$code}}]`"
                                class="form-control input-small inline-selector"
                                v-model="priceItem.subscribe_duration_desc['{{$code}}']"
                                placeholder="@lang("Description") - {{$code}}"/>
                        @endforeach

                        <button @click="removePriceItem(priceItem.key)" class="btn btn-sm red">
                            <i class="fa fa-trash active"></i>
                        </button>

                        <span class="help-block" style="margin: 0px 36px;">

                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="/admin/assets/global/plugins/vue@3.2.40/dist/vue.global.js"
  type="text/javascript"></script>
<script>

  const { createApp } = Vue;
  createApp({
        data() {
            return {
              id: 1,
              action: 'create',
              price: null,
              offer_percentage: null,
              start_offer_date: null,
              end_offer_date: null,
              same_pricerenew_times: null,
              max_puse_days: null,
              days_count: null,
              subscribe_number: null,
              subscribe_number_status: false,
              subscribe_duration_desc: { },
              package_prices: @json($extraData['package_prices']),
            };
        },
        methods: {
            addPrice(){
                if(this.price){

                    this.package_prices.push({
                        id: this.id,
                        key: `${this.action}_${this.id}`,
                        action: this.action,
                        price: this.price,
                        offer_percentage: this.offer_percentage,
                        start_offer_date: this.start_offer_date,
                        end_offer_date: this.end_offer_date,
                        same_pricerenew_times: this.same_pricerenew_times,
                        subscribe_duration_desc: this.subscribe_duration_desc,
                        max_puse_days: this.max_puse_days,
                        days_count: this.days_count,
                        subscribe_number: this.subscribe_number,
                        subscribe_number_status: this.subscribe_number_status,

                    });

                    this.id ++;
                    this.clearInputs();
                }
            },
            removePriceItem(key){
                let item = this.package_prices.map((priceItem) => priceItem.key).indexOf(key);
                if (item || item == 0) {
                    this.package_prices.splice(item, 1);
                    return true;
                }

                return false;
            },
            clearInputs(){
                this.price = null;
                this.offer_percentage = null;
                this.start_offer_date = null;
                this.end_offer_date = null;
                this.same_pricerenew_times = null;
                this.max_puse_days = null;
                this.days_count = null;
                this.subscribe_duration_desc ={ };
                this.subscribe_number = null;
                this.subscribe_number_status = false;
            },
        },
    }).mount('#app');
</script>
@endpush
