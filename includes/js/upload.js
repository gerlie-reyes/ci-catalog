$(document).ready(function($) {
    var canPost = true;
    var options = {
        beforeSend: function(f){
            var count_img = $("input:radio[name=primary_photo]").length;
            if(count_img >= 5){
                //alert('Maximum of 5 uploads only.');
                modalView("alert-max","Maximum File Upload","Maximum of 5 photos per ad.")
                f.abort();
            } else {
                // Replace this with your loading gif image
            $(".upload-image-messages").html('<img src = "'+get_base_url()+'includes/img/gif-load.gif" class = "loader" width="20" height="20" /> Please wait.. <span class="percent"></span>').css('display', 'inline-block');
            }
            canPost = false;
        },
        complete: function(response){
            //Output AJAX response to the div container
           
            res = $.parseJSON(response.responseText);
            console.log(res);

            if(res.errors){
                $(".upload-image-messages").html('<div class="alert alert-danger" >' + res.errors + '</div>');
                return false;
            }
            
            var count_img = $("input:radio[name=primary_photo]").length;
            $.each(res, function(i, val) {
                 if(count_img < 5){
                 $('<li>'+ 
                    '<span class="remove-photo glyphicon glyphicon-remove" aria-hidden="true"></span>'+
                    '<img  class="img-responsive" width="91" height="70" src="'+get_base_url()+'includes/uploads/'+val.file_name+'" />'+
                    '<input type="hidden" value="'+val.file_name+'" name="images[]" />'+
                    '<div class="radio">'+
                    '   <label>'+
                    '        <input type="radio" value="'+val.file_name+'" name="primary_photo"> Primary Photo'+
                    '    </label>'+
                    '</div></li>').appendTo($('#ad-upload ul')); 
                    count_img++;
                 } else {
                    modalView("alert-max","Maximum File Upload","Maximum of 5 photos per ad.");
                    return false;
                 }
            });
            $("input:radio[name=primary_photo]:first").attr('checked', true);
            $('#img-select').val('');
            $(".upload-image-messages").hide();
            $('#add-form-submit').button('reset');
            canPost = true;
        },
        uploadProgress: function(event, pos, total, percentComplete){
//            console.log("pos:"+pos);
            $(".upload-image-messages .percent").html(percentComplete+"% complete");
        }
    };  
    // Submit the form  
    //$(".upload-image-form").ajaxForm(options); 

    $("input:file").change(function(){
        $(".upload-image-form").ajaxSubmit(options); 
    });

    $('#post-ad-form').on('submit', function(){
        if(!canPost){
            //alert('Uploading.. Please wait.');
            $('#add-form-submit').button('loading');
            return false;
        }
    }); 
});