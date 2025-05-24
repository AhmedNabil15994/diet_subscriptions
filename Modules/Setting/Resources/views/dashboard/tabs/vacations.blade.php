<div class="tab-pane fade"
  id="vacations">
  <div class="col-md-10">
    <div class="tab-pane fade in"
      id="restaurant_">
      <div class="col-md-10">
        <div class="form-group">
          <label class="col-md-2">
            {{ __('setting::dashboard.settings.form.week_end') }}
          </label>
          <div class="col-md-9">
            <select name="week_end[]"
              id="single"
              class="form-control select2"
              multiple="">
              @foreach (__('setting::dashboard.settings.form.days')??[] as $dayCode=> $day)
              <option value="{{ $dayCode }}"
                @if(setting('week_end')&&in_array($dayCode,setting('week_end'))))
                selected
                @endif>
                {{ $day }}
              </option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2">
            <button type="button"
              id="btnAddMoreCustomVacations"
              class="btn btn-success">
              {{ __('setting::dashboard.settings.form.vacations.form.add_more') }}
            </button>
          </label>
        </div>
        <div class="form-group">
          <label class="col-md-2"></label>
          <div class="col-md-9">
            <table class="table-striped table-bordered table-hover table">
              <thead>
                <tr>
                  <th class="text-center">{{ __('setting::dashboard.settings.form.vacations.form.date_range') }}</th>
                </tr>
              </thead>
              <tbody id="customVacationsBody">
                @if(setting('vacation'))
                @foreach (setting('vacation','date_range') as $k => $vacation)
                @php
                $vacation=explode(' - ',$vacation)
                @endphp
                <tr id="customVacationsRow-{{$k}}"
                  class="text-center">
                  <td>
                    <input type="text"
                      readonly
                      class="form-control date-range-picker"
                      value="{{ $vacation[0] . ' - ' . $vacation[1] }}"
                      name="vacation[date_range][{{$k}}]"
                      data-name="vacation.date_range.{{$k}}">
                    <div class="help-block"></div>
                  </td>
                  <td>
                    <button type="button"
                      class="btn btn-danger"
                      onClick="removeCustomVacations('{{ $k }}')">
                      <i class="fa fa-trash-o"></i>
                    </button>
                  </td>
                </tr>
                @endforeach
                @endif
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>


  </div>
</div>
@push('scripts')
<script>
  $("#btnAddMoreCustomVacations").click(function () {
  var rowCount = Math.floor(Math.random() * 9000000000) + 1000000000;
  var customVacationsRow = `
  <tr id="customVacationsRow-${rowCount}"
    class="text-center">
    <td>
      <input type="text"
        readonly
        class="form-control date-range-picker"
        name="vacation[date_range][${rowCount}]"
        data-name="vacation.date_range.${rowCount}">
      <div class="help-block"></div>
    </td>
    <td>
      <button type="button"
        class="btn btn-danger"
        onclick="removeCustomVacations(${rowCount})">
        <i class="fa fa-trash-o"></i>
      </button>
    </td>
  </tr>`;
  $("#customVacationsBody").prepend(customVacationsRow);
      initDateRange();
  });


  function initDateRange() {
    var DateRange = $('.date-range-picker');
    DateRange.daterangepicker({
      autoUpdateInput: false,
      locale: {
        cancelLabel: 'Clear',
        format: 'YYYY-MM-DD',
      }
    });

      DateRange.on('apply.daterangepicker', function (ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
      });

      DateRange.on('cancel.daterangepicker', function (ev, picker) {
      $(this).val('');
      });
    }


    function removeCustomVacations(rowId) {
      $('#customVacationsRow-' + rowId).remove();
      }
</script>
@endpush
