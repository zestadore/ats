<tr>
    <td>
        <input class="form-control hrs {{ $errors->has('hours[]') ? ' is-invalid' : '' }} hrs" placeholder="Hours" name="hours[]" id="hours" type="number" required>
    </td>
    <td>
        <input class="form-control {{ $errors->has('from_date[]') ? ' is-invalid' : '' }}" placeholder="From date" name="from_date[]" id="from_date" type="date" required>
    </td>
    <td>
        <input class="form-control {{ $errors->has('to_date[]') ? ' is-invalid' : '' }}" placeholder="To date" name="to_date[]" id="to_date" type="date" required>
    </td>
    <td>
        <input class="form-control {{ $errors->has('rate[]') ? ' is-invalid' : '' }} rate" placeholder="Rate" name="rate[]" id="rate" type="number" required>
    </td>
    <td>
        <input class="form-control {{ $errors->has('amount[]') ? ' is-invalid' : '' }} amt" placeholder="Amount" name="amount[]" id="amount" type="number" required>
    </td>
    <td>
        <span style="float: right;font-size: 20px;padding:15px;color:green;" class="addDetailsButton"><i class="fadeIn animated bx bx-plus-circle"></i></span>
        <span style="float: right;font-size: 20px;padding:15px;color:red;" class="remove_button"><i class="fadeIn animated fa fas fa-trash-alt"></i></span>
    </td>
</tr>