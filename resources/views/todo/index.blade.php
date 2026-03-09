<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .table td {
            vertical-align: middle;
        }

        .action-btns button {
            margin-right: 5px;
        }
    </style>

</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Task Flow</a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-dark px-4">Logout</button>
            </form>

        </div>
    </nav>

    <!-- Main -->
    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card p-5">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif



                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Add Task -->
                    <form method="POST" action="{{ route('todo.store') }}">
                        @csrf

                        <div class="row g-2">

                            <div class="col-md-6">
                                <input type="text" name="task"
                                    class="form-control @error('task') is-invalid @enderror"
                                    placeholder="Enter task...">
                                @error('task')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <select name="priority" class="form-select @error('priority') is-invalid @enderror">
                                    <option disabled selected>Priority</option>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                                @error('priority')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                    class="form-control @error('due_date') is-invalid @enderror">
                                @error('due_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 d-grid mt-2">
                                <button class="btn btn-primary">Add Task</button>
                            </div>

                        </div>
                    </form>

                    <hr class="my-4">

                    <!-- Filters -->
                    <div class="row g-2 mb-3">

                        <div class="col-md-4">
                            <select class="form-select" id="filterStatus">
                                <option value="">Select Status</option>
                                <option value="Pending">Pending</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <select class="form-select" id="filterPriority">
                                <option value="">Select Priority</option>
                                <option>Low</option>
                                <option>Medium</option>
                                <option>High</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <input type="text" id="searchTask" class="form-control" placeholder="Search task...">
                        </div>

                    </div>

                    <!-- Task Table -->
                    <div class="table-responsive">

                        @if ($tasks->count())
                            <table class="table table-hover">

                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Task</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th width="180">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($tasks as $task)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $task->title }}</td>

                                            <td>
                                                <span
                                                    class="badge bg-dark px-4 fs-6">{{ ucfirst($task->priority) }}</span>
                                            </td>

                                            <td>
                                                <span
                                                    class="badge bg-primary px-3 fs-6">{{ ucfirst($task->status) }}</span>
                                            </td>

                                            <td class="d-flex gap-2">
                                                @if ($task->status !== 'complete')
                                                    <a class="btn btn-sm btn-dark px-3"
                                                        href="{{ route('todo.edit', $task->id) }}">Edit</a>

                                                    <form method="POST"
                                                        action="{{ route('todo.destroy', $task->id) }}"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger px-3">Delete</button>
                                                    </form>

                                                    <form method="POST" action="{{ route('task.status', $task->id) }}"
                                                        class="d-inline">
                                                        @csrf
                                                        <button class="btn btn-sm btn-success px-3">Done</button>
                                                    </form>
                                                @else
                                                    <form method="POST"
                                                        action="{{ route('todo.destroy', $task->id) }}"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger px-3">Delete</button>
                                                    </form>
                                                @endif


                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                            <div>
                                {!! $tasks->links() !!}
                            </div>
                        @else
                            <div class="alert alert-danger">No Task Found!</div>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
