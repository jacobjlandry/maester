{{-- files modal --}}
<div class="ui modal" id="fileModal{{ $file->id }}">
    <i class="close icon"></i>
    <div class="header">
        {{ $file->name }}.{{ $file->extension }}
    </div>
    <div class="content" style="text-align: center;">
        @if($file->fileType() == 'image')
            <div class="image">
                <img src="/file/{{ $file->id }}"  style="max-width: 800px;"/>
            </div>
        @elseif($file->fileType() == 'pdf')
            <canvas id="pdf{{ $file->id }}" style="max-width: 800px;"></canvas>
            @push('scripts')
                <script type="text/javascript">
                    $(document).ready(function() {
                        var loadingTask = PDFJS.getDocument('/file/{{ $file->id }}');

                        loadingTask.promise.then(function(pdf) {
                            console.log('PDF loaded');

                            // Fetch the first page
                            var pageNumber = 1;
                            pdf.getPage(pageNumber).then(function(page) {
                                console.log('Page loaded');

                                var scale = 1.5;
                                var viewport = page.getViewport(scale);

                                // Prepare canvas using PDF page dimensions
                                var canvas = document.getElementById('pdf{{ $file->id }}');
                                var context = canvas.getContext('2d');
                                canvas.height = viewport.height;
                                canvas.width = viewport.width;

                                // Render PDF page into canvas context
                                var renderContext = {
                                    canvasContext: context,
                                    viewport: viewport
                                };
                                var renderTask = page.render(renderContext);
                                renderTask.then(function () {
                                    console.log('Page rendered');
                                });
                            });
                        }, function (reason) {
                            // PDF loading error
                            console.error(reason);
                        });
                    });
                </script>
            @endpush
        @elseif($file->fileType() == 'code')
            <div id="code{{ $file->id }}" style="text-align: left;"></div>
            @push('scripts')
                <script type="text/javascript">
                    $(document).ready(function() {
                        var converter = new showdown.Converter();
                        text = `{{ $file->contents() }}`;
                        html = converter.makeHtml(text);
                        $('#code{{ $file->id }}').html(html);
                    });
                </script>
            @endpush
        @else
            <a href="{{ route('file.download', ['id' => $file->id]) }}" class="ui button green">Download File</a>
        @endif
    </div>
</div>