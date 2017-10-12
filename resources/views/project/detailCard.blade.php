<div class="ui card">
    <div class="content">
        <div class="description" style="margin-bottom: 15px;">
            <b>Source Code URL</b><br />
            <a href="{{ $project->source_code_url }}">{{ $project->source_code_url }}</a>
        </div>
        <div class="description" style="margin-bottom: 15px;">
            <b>Production URL</b><br />
            <a href="{{ $project->production_url }}">{{ $project->production_url }}</a>
        </div>
        <div class="description" style="margin-bottom: 15px;">
            <b>Test URL</b><br />
            <a href="{{ $project->test_url }}">{{ $project->test_url }}</a>
        </div>
        <div class="description" style="margin-bottom: 15px;">
            <b>Dev URL</b><br />
            <a href="{{ $project->dev_url }}">{{ $project->dev_url }}</a>
        </div>
    </div>
</div>