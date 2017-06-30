@extends('layouts.app')
@section('content')
    @component('components.page-header')
        @slot('icon')
            fa fa-users
        @endslot
        @slot('header')
            Suppliers
        @endslot
        Manage Suppliers
    @endcomponent
    <div class="widget">
        <div class="widget-header">
            <h2><strong>Supplier Details</strong></h2>
        </div>
        <div class="widget-content padding">
            <div class="col-sm-12">
                <form action="{{ route('supplier.update', $supplier->id) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ $supplier->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input class="form-control" type="text" name="phone_number" id="phone_number" value="{{ $supplier->phone_number }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" type="email" name="email" id="email" value="{{ $supplier->email }}" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input class="form-control" type="text" name="address" id="address" value="{{ $supplier->address }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="account_number">Account Number</label>
                            <input class="form-control" type="text" name="account_number" id="account_number" value="{{ $supplier->account_number }}">
                        </div>
                        @if($supplier->is_system)
                            <div class="form-group">
                                <label for="is_credit" class="control-label">Customer Type</label>
                                <h4>{{ $supplier->is_credit ? 'Credit Customer' : 'Cash Customer' }}</h4>
                            </div>
                        @else
                            <div class="form-group">
                                <label for="is_credit" class="control-label">Customer Type</label>

                                <select name="is_credit" id="is_credit" class="form-control">
                                    <option value="0"{{ $supplier->is_credit ? ' selected' : '' }}>Cash Customer</option>
                                    <option value="1"{{ $supplier->is_credit ? ' selected' : '' }}>Credit Customer</option>
                                </select>
                            </div>
                        @endif
                        @if($supplier->is_credit)
                        <div class="form-group" style="display: none;">
                            <label for="credit_limit">Credit Limit</label>
                            <input type="number" class="form-control" name="credit_limit" id="credit_limit" value="{{ $supplier->credit_limit }}">
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="is_active">Is Active?
                                <input class="form-control" type="checkbox" name="is_active"{{ $supplier->is_active ? 'checked' : '' }} id="is_active">
                            </label>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Save">
                            <a href="{{ route('supplier.index') }}" class="btn btn-danger">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        var credit = $('#credit_limit');
        credit.on('focus', function () {
            this.select();
        });

        $('#is_credit').on('change', function () {
            updateUI();
        });

        function updateUI() {
            if ($('#is_credit').val() == 0) {
                credit.val(0);
                credit.parent().attr('style', 'display:none');
            } else {
                credit.parent().removeAttr('style');
            }
        }

        updateUI();
    </script>
@endsection