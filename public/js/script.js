$(function () {

    $('.hcaption').hcaptions({
        effect: "fade",
        speed: "100"
    });

	function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#previewimg').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#previewbtn").change(function(){
        readURL(this);
    });

    $('#new_content').on('submit', function(){ 
				 
       // ajax post method to pass form data to the 
        $.post(
            $(this).prop('action'),        {
                "_token": $( this ).find( 'input[name=_token]' ).val(),
                "series": $( '#series' ).val(),
                "author": $( '#author' ).val(),
                "artist": $( '#artist' ).val(),
                "publisher": $( '#publisher' ).val(),
                "genre": $( '#genre' ).val(),
                "published_date": $( '#published_date' ).val()
            },
            function(data){
                window.location.replace("/browse");
            },
            'json'
        ); 
       
        return false;
    }); 
});