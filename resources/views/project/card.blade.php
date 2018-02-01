<div class="ui card project-card">
    <div class="image">
        <div class="icon">
            <i class="fa fa-{{ $project->icon }} fa-4x"></i>
        </div>
    </div>
    <div class="content">
        <a class="header" href="/project/{{ $project->id }}">{{ $project->name }}</a>
        <div class="meta">
            <span class="date">Created by {{ $project->creator->name }} on {{ $project->created_at->toDateString() }}</span>
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
        <div class="comments">
            <a class='ui' href="#comments">
                <i class="fa fa-comments"></i> {{ $project->comments->count() }}
            </a>
        </div>
        <div class="users" id="project-users">
            <a class='ui' href="#">
                <i class="fa fa-user"></i> {{ $project->users->count() }}
            </a>
        </div>
    </div>
</div>

@if(Auth::user()->can('update', $project))
    <div class="ui modal">
        <div class="header">Manage {{ $project->name }}'s Team</div>
        <div class="content">
            <h3>Project Team</h3>
            <div class="ui list project-creator">
                <div class="item user">
                    <div class="avatar image">
                                    <span class="fa-stack fa-sm">
                                      <i class="fa fa-circle-o fa-stack-2x"></i>
                                      <i class="fa fa-user fa-stack-1x"></i>
                                    </span>
                    </div>
                    <div class="content">
                        <a class="header">{{ $project->creator->name }}</a>
                        <div class="description">{{ $project->creator->email }} (creator)</div>
                    </div>
                </div>
            </div>

            <div id="project-team" class="container ui list">
                @foreach($project->users as $user)
                    @if($project->created_by != $user->id)
                        <div class="item user" user_id="{{ $user->id }}" project_id="{{ $project->id }}">
                            <div class="avatar image">
                                <span class="fa-stack fa-sm">
                                  <i class="fa fa-circle-o fa-stack-2x"></i>
                                  <i class="fa fa-user fa-stack-1x"></i>
                                </span>
                            </div>
                            <div class="content">
                                <a class="header">{{ $user->name }}</a>
                                <div class="description">{{ $user->email }}</div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="content">
            <h3>Available Users</h3>
            <div id="remaining-users" class="container ui list">
                @foreach(\App\User::withoutProject($project) as $user)
                    <div class="item user" user_id="{{ $user->id }}" project_id="{{ $project->id }}">
                        <div class="avatar image">
                            <span class="fa-stack fa-sm">
                              <i class="fa fa-circle-o fa-stack-2x"></i>
                              <i class="fa fa-user fa-stack-1x"></i>
                            </span>
                        </div>
                        <div class="content">
                            <a class="header">{{ $user->name }}</a>
                            <div class="description">{{ $user->email }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="actions">
            <div class="left">
                <div class="ui cancel button">Close</div>
            </div>
            <div class="right">

            </div>
        </div>
    </div>
@endif

@push('scripts')
    @if(Auth::user()->can('update', $project))
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        $('#project-users').on('click', function() {
            $('.ui.modal').modal('show');
        });

        dragula([document.querySelector('#project-team'), document.querySelector('#remaining-users')], {
            revertOnSpill: true
        }).on('drop', function (el) {
            if($(el).parent().attr('id') == 'project-team') {
                var type = 'attach';
            }
            else {
                var type = 'detach';
            }

            $.ajax({
                type: "POST",
                url: '/projectuser',
                data: { 'user_id' : $(el).attr('user_id'), 'project_id' : $(el).attr('project_id'), 'type' : type }
            });
        });
    @endif
@endpush