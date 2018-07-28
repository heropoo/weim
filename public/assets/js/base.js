$(function(){
    $('.open_window').click(function(){
        var data_url = $(this).attr('data-url');
        //alert(data_url);
        window.location.href = data_url;
        return false;
    });
    $('.select_contacts').click(function() {
        $(this).css('background', '#36373C').css('opacity', '0.3')
        $(this).children('a').css('opacity', '1');
    })
});