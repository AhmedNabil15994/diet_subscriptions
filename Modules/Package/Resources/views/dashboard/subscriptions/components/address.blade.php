<table class="table table-striped">
  <tbody>
    <tr>
      <th scope="col">{{__('Country')}}</th>
      <td>{{optional(optional(optional($address->state)->city)->country)->title}}</td>
    </tr>
    <tr>
      <th scope="col">{{__('City')}}</th>
      <td>{{optional(optional($address->state)->city)->title}}</td>
    </tr>
    <tr>
      <th scope="col">{{__('State')}}</th>
      <td>{{optional($address->state)->title}}</td>
    </tr>
    <tr>
      <th scope="col">{{__('Streat')}}</th>
      <td>{{optional($address)->street}}</td>
    </tr>
    <tr>
      <th scope="col">{{__('Block No.')}}</th>
      <td>{{optional($address)->block}}</td>
    </tr>
    <tr>
      <th scope="col">{{__('Building No., Floor, Flat No.')}}</th>
      <td>{{optional($address)->building}}</td>
    </tr>
  </tbody>
</table>