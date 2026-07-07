@if(session('success'))
    <div class="alert alert-success rounded-4 shadow-sm" role="alert">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger rounded-4 shadow-sm" role="alert">
        {{ session('error') }}
    </div>
@endif
