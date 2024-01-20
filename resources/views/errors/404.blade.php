<!-- resources/views/errors/404.blade.php -->


    <div class="container">
        <h1>404 Not Found</h1>
        <p>The requested URL <strong>{{ url()->full() }}</strong> with method <strong>{{ request()->method() }}</strong> was not found.</p>
        <pre>{{ request() }}</pre>
        <p>Customize this view as needed.</p>
    </div>
