<div class="card-body">
    <div class="row container">
        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
            <x-forms.input class="form-control hrs {{ $errors->has('hours[]') ? ' is-invalid' : '' }}" title="Hours" name="hours[]" id="hours" type="number" required="True"/>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
            <x-forms.input class="form-control {{ $errors->has('from_date[]') ? ' is-invalid' : '' }}" title="From date" name="from_date[]" id="from_date" type="date" required="True"/>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
            <x-forms.input class="form-control {{ $errors->has('to_date[]') ? ' is-invalid' : '' }}" title="To date" name="to_date[]" id="to_date" type="date" required="True"/>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
            <x-forms.input class="form-control rate {{ $errors->has('rate[]') ? ' is-invalid' : '' }}" title="Rate" name="rate[]" id="rate" type="number" required="True"/>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
            <x-forms.input class="form-control amt {{ $errors->has('amount[]') ? ' is-invalid' : '' }}" title="Amount" name="amount[]" id="amount" type="number" required="True"/>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 remove_button">
            <span style="float: right;font-size: 20px;padding:15px;color:red;"><i class="fadeIn animated bx bx-trash"></i></span>
        </div>
    </div>
</div>