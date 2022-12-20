
$('.navbar-toggler').on('click',function(){
    
    var width = $(window).width(); 

    if (width >= 1024) {
        $('body').toggleClass('sidebar-lg-show');
    }
    else {
        $('body').toggleClass('sidebar-show');
    }
})
