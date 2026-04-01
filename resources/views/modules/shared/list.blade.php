<div class="glass-card p-6">
    <div class="mb-5 flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
        <div>
            <h2 class="text-2xl font-semibold">{{ $heading }}</h2>
            <p class="text-sm text-slate-300">{{ $subheading ?? 'Manage records with create, review, edit and delete actions.' }}</p>
        </div>
        <a href="{{ $createRoute }}" class="glass-button">Create New</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="border-b border-white/10 text-left text-slate-300">
                    @foreach($columns as $column)
                        <th class="py-3 pr-4 font-medium">{{ $column }}</th>
                    @endforeach
                    <th class="py-3 pr-4 font-medium">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rows as $row)
                    <tr class="border-b border-white/5 align-top transition hover:bg-white/5">
                        @foreach($rowRenderer($row) as $cell)
                            <td class="py-4 pr-4 text-slate-100">{{ $cell }}</td>
                        @endforeach
                        <td class="py-4 pr-4">
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route($routeBase . '.show', $row->_id) }}" class="rounded-full border border-white/15 bg-white/10 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-white/15">Review</a>
                                <a href="{{ route($routeBase . '.edit', $row->_id) }}" class="rounded-full border border-amber-300/20 bg-amber-500/20 px-3 py-1.5 text-xs font-medium text-amber-100 transition hover:bg-amber-500/30">Edit</a>
                                <form method="POST" action="{{ route($routeBase . '.destroy', $row->_id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-full border border-rose-300/20 bg-rose-500/20 px-3 py-1.5 text-xs font-medium text-rose-100 transition hover:bg-rose-500/30">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) + 1 }}" class="py-6 text-center text-slate-300">No records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-5 rounded-2xl border border-white/10 bg-white/5 p-3">{{ $rows->links() }}</div>
</div>
