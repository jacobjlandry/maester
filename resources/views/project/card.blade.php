<div class="ui card project-card">
    <div class="image">
        <div class="icon">
            <i class="fa fa-{{ $project->icon }} fa-4x"></i>
        </div>
    </div>
    <div class="content">
        <a class="header" href="/project/{{ $project->id }}">{{ $project->name }}</a>
        <div class="meta">
            <span class="date">Created on {{ $project->created_at->toDateString() }}</span>
        </div>
        <div class="description">
            {{ $project->description }}
        </div>
    </div>
    <div class="extra">
        <div class="bugs">
            <a class='ui' href="#">
                <i class="fa fa-bug"></i> {{ $project->bugs->count() }}
            </a>
        </div>
        <div class="features">
            <a class='ui' href="#">
                <i class="fa fa-list"></i> {{ $project->features->count() }}
            </a>
        </div>
        <div class="users">
            <a class='ui' href="#">
                <i class="fa fa-user"></i> {{ $project->users->count() }}
            </a>
        </div>
    </div>
</div>