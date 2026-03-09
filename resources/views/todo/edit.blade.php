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
                    <form method="POST" action="{{ route('todo.update', $todo->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-2">

                            <div class="col-md-6">
                                <input type="text" name="task"
                                    class="form-control @error('task') is-invalid @enderror"
                                    placeholder="Enter task..." value="{{ $todo->title }}">
                                @error('task')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <select name="priority" class="form-select @error('priority') is-invalid @enderror">
                                    <option value="" disabled selected>Priority</option>
                                    <option value="low" {{ $todo->priority == 'low' ? 'selected' : ''  }}>Low</option>
                                    <option value="medium" {{ $todo->priority == 'medium' ? 'selected' : ''  }}>Medium</option>
                                    <option value="high" {{ $todo->priority == 'high' ? 'selected' : ''  }}>High</option>
                                </select>
                                @error('priority')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                    class="form-control @error('due_date') is-invalid @enderror" value="{{ $todo->due_date }}">
                                @error('due_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 gap-3 mt-4">
                                <button class="btn btn-primary">Save Changes</button>
                                <a href="{{ route('todo.index') }}" class="btn btn-dark px-4">Back</a>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
