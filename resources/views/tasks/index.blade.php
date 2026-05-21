<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskFlow - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-50 flex font-sans text-slate-900">

    @include('tasks.partials.sidebar')

    <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <div class="flex-1 overflow-y-auto p-6 lg:p-8">
            <div class="max-w-7xl mx-auto">

                @if(session('success'))
                    <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-start sm:items-center justify-between shadow-sm">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <div class="mb-8">
                    <h1 class="text-2xl font-semibold text-slate-900">Dashboard</h1>
                    <p class="text-sm text-slate-500 mt-1">Manage your tasks and stay productive</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500 mb-1">Total Pending Tasks</p>
                            <div class="flex items-baseline gap-3">
                                <h3 class="text-3xl font-bold text-slate-900">{{ $tasks->where('status', 'pending')->count() }}</h3>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-700">Active</span>
                            </div>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500 mb-1">Urgent Deadlines</p>
                            <div class="flex items-baseline gap-3">
                                <h3 class="text-3xl font-bold text-slate-900">{{ $urgentCount }}</h3>
                                @if($urgentCount > 0)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-50 text-red-700 border border-red-100">{{ $urgentCount }} overdue</span>
                                @endif
                            </div>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-amber-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500 mb-1">Completed Tasks</p>
                            <div class="flex items-baseline gap-3">
                                <h3 class="text-3xl font-bold text-slate-900">{{ $tasks->where('status', 'completed')->count() }}</h3>
                                <span class="text-xs font-medium text-emerald-600">+12 this week</span>
                            </div>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                    
                    <div class="lg:col-span-2 flex flex-col gap-6">
                        
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/50 flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-slate-900">Pending Tasks</h2>
                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">{{ $tasks->where('status', 'pending')->count() }}</span>
                            </div>
                            <div class="p-6">
                                @if($tasks->where('status', 'pending')->count() > 0)
                                    <div class="space-y-4">
                                        @foreach($tasks->where('status', 'pending') as $task)
                                            @php
                                                $isOverdue = \Carbon\Carbon::parse($task->due_date)->isPast() && $task->status !== 'completed';
                                                $categoryName = $task->category->name;
                                                $categoryStyles = match($categoryName) {
                                                    'Work' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                                    'Personal' => 'bg-purple-50 text-purple-700 border-purple-200',
                                                    'Study' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                    default => 'bg-slate-50 text-slate-700 border-slate-200',
                                                };
                                            @endphp
                                            <div class="relative bg-white rounded-xl border p-5 shadow-sm transition-all hover:shadow-md {{ $isOverdue ? 'border-red-200' : 'border-slate-200' }}">
                                                @if($isOverdue)
                                                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-red-500 rounded-l-xl"></div>
                                                @endif
                                                <div class="flex items-start gap-4">
                                                    <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="mt-1">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="w-6 h-6 rounded-full border-2 border-slate-300 flex items-center justify-center text-transparent hover:border-indigo-600 hover:text-indigo-600 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                        </button>
                                                    </form>
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 mb-2">
                                                            <div>
                                                                <h4 class="text-base font-semibold text-slate-900 leading-tight mb-1">{{ $task->title }}</h4>
                                                                @if($task->description)
                                                                    <p class="text-sm text-slate-500 line-clamp-2">{{ $task->description }}</p>
                                                                @endif
                                                            </div>
                                                            <div class="flex items-center gap-2">
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border whitespace-nowrap {{ $categoryStyles }}">
                                                                    {{ $categoryName }}
                                                                </span>
                                                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                                                                    @csrf @method('DELETE')
                                                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this task?')" class="text-slate-400 hover:text-red-500 transition-colors focus:outline-none">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class="flex items-center mt-4">
                                                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium {{ $isOverdue ? 'bg-red-50 text-red-700 border border-red-200' : 'text-slate-500 bg-slate-50 border border-slate-200' }}">
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                                <span>{{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</span>
                                                                @if($isOverdue) <span class="ml-1 font-bold uppercase tracking-wider text-[10px]">• Overdue</span> @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-12">
                                        <p class="text-slate-500">No pending tasks. You're all caught up!</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if($tasks->where('status', 'completed')->count() > 0)
                            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/50 flex items-center justify-between">
                                    <h2 class="text-lg font-semibold text-slate-900">Completed Tasks</h2>
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">{{ $tasks->where('status', 'completed')->count() }}</span>
                                </div>
                                <div class="p-6">
                                    <div class="space-y-3">
                                        @foreach($tasks->where('status', 'completed') as $task)
                                            @php
                                                $categoryName = $task->category->name;
                                                $categoryStyles = match($categoryName) {
                                                    'Work' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                                    'Personal' => 'bg-purple-50 text-purple-700 border-purple-200',
                                                    'Study' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                    default => 'bg-slate-50 text-slate-700 border-slate-200',
                                                };
                                            @endphp
                                            <div class="bg-slate-50/50 rounded-xl border border-slate-200 p-4 shadow-sm opacity-75 hover:opacity-100 transition-opacity">
                                                <div class="flex items-center gap-4">
                                                    <div class="flex-shrink-0">
                                                        <svg class="w-6 h-6 text-emerald-500 fill-emerald-50" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                                    </div>
                                                    <div class="flex-1 min-w-0 flex items-center justify-between gap-4">
                                                        <div class="min-w-0">
                                                            <h4 class="text-sm font-semibold text-slate-700 line-through truncate">{{ $task->title }}</h4>
                                                            <div class="flex items-center gap-2 mt-1">
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium border {{ $categoryStyles }}">
                                                                    {{ $categoryName }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="flex items-center gap-2">
                                                            <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                                                @csrf @method('PATCH')
                                                                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 hover:text-slate-900 transition-colors focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-1">
                                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                                    Reopen
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                                                                @csrf @method('DELETE')
                                                                <button type="submit" onclick="return confirm('Are you sure you want to delete this task?')" class="text-slate-400 hover:text-red-500 transition-colors focus:outline-none">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 sticky top-6">
                            <div class="mb-6">
                                <h2 class="text-lg font-semibold text-slate-900">Add New Task</h2>
                                <p class="text-sm text-slate-500">Create a new objective</p>
                            </div>
                            
                            @if ($errors->any())
                                <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 text-xs rounded-lg space-y-1">
                                    @foreach ($errors->all() as $error) <div>• {{ $error }}</div> @endforeach
                                </div>
                            @endif

                            <form action="{{ route('tasks.store') }}" method="POST" class="space-y-5">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Title <span class="text-red-500">*</span></label>
                                    <input type="text" name="title" id="title" required value="{{ old('title') }}" placeholder="e.g. Finish project proposal" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Description <span class="text-slate-400 font-normal">(optional)</span></label>
                                    <textarea name="description" id="description" rows="3" placeholder="Add any extra details..." class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow resize-none">{{ old('description') }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Category</label>
                                    <select name="category_id" id="category" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Due Date <span class="text-red-500">*</span></label>
                                    <input type="date" name="due_date" id="dueDate" required value="{{ old('due_date', date('Y-m-d')) }}" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow">
                                </div>
                                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Add Task
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

</body>
</html>
