@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show py-3 shadow-sm rounded-3" role="alert">
        <i class="bi bi-check-circle me-2 text-success"></i>
        <x-heroicon-o-check-circle class="hero-icon-sm text-success" />
        {{ $message }}
        <x-btn-alert-dismiss />
    </div>
@endif
@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show py-3 shadow-sm rounded-3" role="alert">
        <i class="bi bi-x-circle text-danger"></i>
        {{ $message }}
        <x-btn-alert-dismiss />
    </div>
@endif
@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-dismissible fade show py-3 shadow-sm rounded-3" role="alert">
        <i class="bi bi-exclamation-triangle text-black"></i>
        {{ $message }}
        <x-btn-alert-dismiss />
    </div>
@endif
@if ($message = Session::get('info'))
    <div class="alert alert-info alert-dismissible fade show py-3 shadow-sm rounded-3" role="alert">
        <x-heroicon-o-information-circle class="hero-icon-sm text-primary" />
        {{ $message }}
        <x-btn-alert-dismiss />
    </div>
@endif
@if ($message = Session::get('status'))
    <div class="alert alert-info alert-dismissible fade show py-3 shadow-sm rounded-3" role="alert">
        <x-heroicon-o-information-circle class="hero-icon-sm text-primary" />
        {{ $message }}
        <x-btn-alert-dismiss />
    </div>
@endif
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show py-3 shadow-sm rounded-3" role="alert">
            <x-heroicon-o-information-circle class="hero-icon-sm text-danger" />
            {{ $error }}
            <x-btn-alert-dismiss />
        </div>
    @endforeach
@endif
