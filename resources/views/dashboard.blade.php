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

    <!-- نموذج جديد -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('task.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Task Name:</label>
                            <input type="text" class="form-control" id="recipient-name" name="Task_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Task Description:</label>
                            <textarea class="form-control" id="message-text" name="Description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="due-time" class="col-form-label">Due Time:</label>
                            <input type="datetime-local" class="form-control" id="due-time" name="Due_time" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Task</button>
                </div>
                </form>
            </div>
        </div>
    </div>



    <div class="container d-flex flex-column align-items-center" style="margin-top: 20px;">
    </div>
    <div class="container d-flex flex-column align-items-center" style="margin-top: 20px;">
    </div>
    <div class="container d-flex flex-column align-items-center" style="margin-top: 20px;">

        <h1 class="mb-4">Daily Tasks</h1>

        <!-- Form to delete all tasks based on status -->
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete all pending tasks?
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('delete.tasks', ['status' => 'pending']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete Tasks</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="container d-flex flex-column align-items-center" style="margin-top: 20px;">
            @foreach ($tasks as $task)
                <div class="card w-75 mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="content">
                            <h4 class="card-title">{{ $task->Task_name }}</h4>
                            <h5 class="text-body-secondary">Description: {{ $task->Description }}</h5>
                            <p class="card-text"><small class="text-body-secondary">Due Time:
                                    {{ $task->Due_time }}</small></p>
                        </div>
                        <div class="buttons">
                            <!-- Form to delete individual task -->
                            <form action="{{ route('task.destroy', $task->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this task?');">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </form>
                            <!-- Button to trigger finish task modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModalCenter-{{ $task->id }}">
                                <i class="bi bi-check-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal for finishing task -->
                <div class="modal fade" id="exampleModalCenter-{{ $task->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle-{{ $task->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle-{{ $task->id }}">Task
                                    Finish
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('task.update', $task->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="result-{{ $task->id }}" class="col-form-label">Task
                                            Result:</label>
                                        <input type="text" class="form-control" id="result-{{ $task->id }}"
                                            name="result" required>
                                    </div>
                                    <input type="hidden" name="Status" value="finished">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary mx-3">Finish Task</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
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
