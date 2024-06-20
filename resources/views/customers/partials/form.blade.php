<form action="{{ isset($customer) ? route('customers.update', $customer) : route('customers.store') }}" method="POST"
    enctype="multipart/form-data" role="form">
    @csrf
    @isset($customer)
        @method('PUT')
    @endisset

    @include('customers.partials.profile')
    @include('customers.partials.contact')
    @include('customers.partials.home-address')
    @include('customers.partials.company')
    @include('customers.partials.others')



    <div class="mb-3">
        <button class="btn btn-primary" type="submit">
            @lang('Save')
        </button>
    </div>
</form>
