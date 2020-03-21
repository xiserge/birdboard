<div class="card" style="height: 200px">
    <h3 class="font-normal text-2xl py-4 pl-4 mb-4 -ml-5 border-l-4 border-blue-400">
        <a href="{{ $project->path() }}">
            {{ $project->title }}
        </a>
    </h3>
    <div class="text-gray-500">{{ Str::limit($project->description, 100) }}</div>
</div>
