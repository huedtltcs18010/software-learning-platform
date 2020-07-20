tinymce.init({
    selector: 'textarea.basic_editor',
    plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    toolbar_mode: 'floating',
    menubar: false,
});

$(function(){
    if ($('.btn-delete').length) {
        $('.btn-delete').unbind('click').bind('click', function (e) {
            e.preventDefault();
            let btnDelete = $(this);
            if (confirm('Are you sure?')) {
                btnDelete.closest('form').submit();
            }
        });
    }

    if ($('.custom-file-input').length) {
        $('.custom-file-input').on('change',function(){
            var fileName = $(this).val();
            var arr = fileName.split('\\');
            fileName = arr[arr.length - 1];
            if (fileName == '') {
                fileName = $(this).data('text');
            }
            $(this).next('.custom-file-label').addClass('selected').html(fileName);
        });
    }

    if ($('.btn-search-series').length) {
        $('.btn-search-series').unbind('click').bind('click', function (e){
            e.preventDefault();
            var btn = $(this);
            var wrapper = btn.closest('.search-series-wrapper');
            var keyword = wrapper.find('.txt-keyword').val();
            var url = btn.data('ajax-url') + '?k=' + encodeURIComponent(keyword);
            $.getJSON(url, function(res) {
                var html = '<small class="text-muted">Found ' + res['total'] + ' series with keyword <b>' + keyword + '</b>. Please choose the series name from the following list:</small>';
                html += '<ul>';
                if (res['total'] > 0) {
                    for (var i = 0; i < res['items'].length; i++) {
                        var item = res['items'][i];
                        html += '<li><a href="javascript:void(0);" class="series-item" data-id="' + item['id']  + '">' + item['name']  + '</a></li>';
                    }
                }
                html += '</ul>';
                wrapper.find('.result').html(html);

                setTimeout(function() {
                    wrapper.find('.series-item').unbind('click').bind('click', function (e){
                        e.preventDefault();
                        wrapper.find('.txt-keyword').val($(this).text());
                        wrapper.find('input[type="hidden"]').val($(this).data('id'));
                        wrapper.find('.result').html('');
                    });
                }, 100);
            });
        });
    }

    if ($('.search-series-wrapper .txt-keyword').length) {
        $('.search-series-wrapper .txt-keyword').keypress(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '13'){
                event.preventDefault();
                $(this).closest('.search-series-wrapper').find('.btn-search-series').click();
            }
        });
    }
})
