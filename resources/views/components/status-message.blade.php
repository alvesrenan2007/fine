<style>

    .status-bar__success-msg{
        background-color: green;
        color: white;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .status-bar__error-msg{
        background-color: red;
        color: white;
        padding: 1rem;
        margin-bottom: 1rem;
    }

</style>

<div class='status-div'>
    @if (session('success'))
        <div class="status-bar__success-msg">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="status-bar__error-msg">
            {{ session('error') }}
        </div>
    @endif
</div>
