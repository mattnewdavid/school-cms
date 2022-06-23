
//Navbar Dropdown Hover Effects
$(document).ready(function(){
    $(".dropdown").hover(function(){
        var dropdownMenu = $(this).children(".dropdown-menu");

        if(dropdownMenu.is(":visible")){
            dropdownMenu.parent().toggleClass("open");
        }
    });
});
//-------------------------------------------//

//Animate On Scroll Initialization
