<tr>
    <td>
        <div class="form-floating mb-3">
            <input class="form-control hrs {{ $errors->has('hours[]') ? ' is-invalid' : '' }} hrs" placeholder="Hours" name="hours[]" id="hours" type="number" required>
            <label class="form-label" for="hours">Hours</label>
        </div>
    </td>
    <td>
        <div class="form-floating mb-3">
            <input class="form-control input-datepicker {{ $errors->has('from_date[]') ? ' is-invalid' : '' }}" placeholder="From date" name="from_date[]" id="FROMDATEFIELD" type="text" required>
            <label class="form-label" for="from_date">From date</label>
        </div>
    </td>
    <td>
        <div class="form-floating mb-3">
            <input class="form-control input-datepicker {{ $errors->has('to_date[]') ? ' is-invalid' : '' }}" placeholder="To date" name="to_date[]" id="TODATEFIELD" type="text" required>
            <label class="form-label" for="to_date">To date</label>
        </div>
    </td>
    <td>
        <div class="form-floating mb-3">
            <input class="form-control {{ $errors->has('rate[]') ? ' is-invalid' : '' }} rate" placeholder="Rate" name="rate[]" id="rate" type="number" required>
            <label class="form-label" for="rate">Rate</label>
        </div>
    </td>
    <td>
        <div class="form-floating mb-3">
            <input class="form-control {{ $errors->has('amount[]') ? ' is-invalid' : '' }} amt" placeholder="Amount" name="amount[]" id="amount" type="number" required>
            <label class="form-label" for="amount">Amount</label>
        </div>
    </td>
    <td>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <span style="float: right;font-size: 20px;padding:15px;color:green;" class="addDetailsButton"><i class="fadeIn animated fa fa-plus-circle"></i></span>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <span style="float: right;font-size: 20px;padding:15px;color:red;" class="remove_button"><i class="fadeIn animated fa fas fa-trash-alt"></i></span>
            </div>
        </div>
    </td>
</tr>