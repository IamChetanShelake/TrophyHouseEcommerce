@if (session('success'))
    <div class="alert alert-success" id="session-message">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger" id="session-message">
        {{ session('error') }}
    </div>
@endif
