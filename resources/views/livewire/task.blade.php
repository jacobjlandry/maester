<div style="text-align: center" wire:init="load">
    @foreach($tasks as $task)
        <div>{{ $task->title }}</div>
    @endforeach
</div>