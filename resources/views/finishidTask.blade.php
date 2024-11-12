<x-app-layout>

    <head>
        <title>View Page</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="{{ asset('view.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>

    @if (session('success'))
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="welcomeToast" class="toast align-items-center text-bg-primary border-0" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="welcomeToast" class="toast align-items-center text-bg-danger border-0" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <div class="container d-flex flex-column align-items-center" style="margin-top: 20px;">
    </div>
    <div class="container d-flex flex-column align-items-center" style="margin-top: 20px;">
    </div>
    <div class="container d-flex flex-column align-items-center" style="margin-top: 20px;">
    </div>
    <div class="container d-flex flex-column align-items-center" style="margin-top: 20px;">
        <h1 class="mb-4">Finished Tasks</h1>
        <div class="container d-flex justify-content-end" style="margin-top: 20px;">
            <button type="button" class="btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="bi bi-trash"></i>
            </button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Confirmation</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete all pending tasks?
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('delete.tasks', ['status' => 'finished']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete Tasks</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($tasks as $task)
            <div class="card w-75 mb-3 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="content">
                        <h4 class="card-title mb-2 fw-bold">{{ $task->Task_name }}</h4>
                        <p class="card-text text-secondary mb-1"><strong>Description:</strong>
                            {{ $task->Description }}
                        </p>
                        <p class="card-text text-secondary mb-1"><strong>Result:</strong> {{ $task->result }}</p>

                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <script>
        // Initialize the toast
        var toastEl = document.getElementById('welcomeToast');
        if (toastEl) {
            var toast = new bootstrap.Toast(toastEl);
            // Show the toast
            toast.show();
            // Auto-hide toast after 10 seconds
            setTimeout(function() {
                toast.hide();
            }, 10000); // 10000 milliseconds = 10 seconds
        }
    </script>
</x-app-layout>
