<div class="project-list-item">
    <div class="title">
        <a href="#">
            <div class="icon"><i class="fa fa-{{ $project->fontawesome }}"></i></div>
            <div class="name">{{ $project->name }}</div>
        </a>
    </div>
    <div class="actions">
        <div class="bugs item">
            <a class='ui' href="#">
                <i class="fa fa-bug"></i> {{ $project->bugs->count() }}
            </a>
        </div>
        <div class="features" style="padding-left: 15px;">
            <a class="ui" href="#">
                <i class="fa fa-list"></i> {{ $project->features->count() }}
            </a>
        </div>
        <div class="users" style="padding-left: 15px;">
            <a class="ui" href="#">
                <i class="fa fa-user"></i> {{ $project->users->count() }}
            </a>
        </div>
    </div>
</div>