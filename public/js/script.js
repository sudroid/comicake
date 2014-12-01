$(function () {

    var sideNavPanel = $('.side-panel').scotchPanel({
                    containerSelector: '.main',
                    direction: 'left',
                    duration: 300,
                    transition: 'ease',
                    distanceX: '20%',
                    enableEscapeKey: true
                });

    $('.toggle-panel').click(function() {
        sideNavPanel.toggle();
        return false;
    });
    

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

    if ($('select').length < 2) { $("#removeGenre").hide(); }
        
    
    $("#removeGenre").click(function(){
        if (($(".dropdown > select").length) <= 2)
        {   
            $("#removeGenre").hide();
            $(".ddlGenres > .dropdown > select:last").remove();  
        }
        else 
        {
            $(".ddlGenres > .dropdown > select:last").remove();  
        }
    });

    $("#addGenre").click(function(){
        $(".ddlGenres > .dropdown > select:last").after('<select class="form-control textupper" name="genres[]">' + $(".dropdown > select").first().html() + '</select>');
        $("#removeGenre").show();
    });

    $("#removeCharacter").hide();
    
    $("#removeCharacter").click(function(){
        if (($(".txtCharacters > .textfield > input").length) <= 2)
        {   
            $("#removeCharacter").hide();
            $(".txtCharacters > .textfield > input:last").remove();  
        }
        else 
        {
            $(".txtCharacters > .textfield > input:last").remove();  
        }
    });

    $("#addCharacter").click(function(){
        $('.txtCharacters > .textfield > input:last').after('<input id="" class="form-control characters" placeholder="Character for your issue?" name="characters[]" type="text" value="">');
        $("#removeCharacter").show();
    });
    
    $('#deleteModal').appendTo("body");
    $("#delete").click(function(){
        $('#deleteModal').modal();
    });
    $('#deactivateModal').appendTo("body");
    $("#deactivate").click(function(){
        $('#deactivateModal').modal();
    });

    $('#deleteUserModal').appendTo("body");
    $(".deleteUser").click(function(){
        $('#deleteUserModal').modal();
    });
  
});