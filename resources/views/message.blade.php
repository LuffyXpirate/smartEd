@if (session()->has('sucess'))
<div class="alert alert-info alert-dismissible fade in" role="alert">
    {{ session('sucess') }}
</div>
@endif

@if (session()->has('error'))
<div class="alert alert-danger " role="alert">
    {{ session('error') }}
</div>
@endif

@if (session()->has('primary'))
<div class="alert alert-primary alert-dismissible fade in" role="alert">
    {{ session('primary') }}
</div>
@endif

@if (session()->has('light'))
<div class="alert alert-light alert-dismissible fade in" role="alert">
    {{ session('light') }}
</div>
@endif
