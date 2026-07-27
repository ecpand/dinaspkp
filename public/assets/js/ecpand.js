$(".carousel").carousel({
    auto: true,
    period: 5000,
    duration: 1000,
    effect: "slide",
    markers: false,
    controlNext: '<span class="mif-chevron-right"></span>',
    controlPrev: '<span class="mif-chevron-left"></span>',
    height: 'false'
});

$('#nav a').on('click', function(event){
    event.preventDefault();
    event.stopPropagation();
});

//css
$('#nav a').css("cursor","pointer");

$(".showMenu").click(function(){
  $("#nav .nav-overlay").addClass('active');
  $("#nav .menu-wrapper").addClass('active');
})

$(".hideMenu").click(function(){
    $("#nav .nav-overlay ul li").removeClass('active');
    $("#nav .nav-overlay ul li").removeClass('hidden');
    $("#nav .nav-overlay").removeClass('active');
    $("#nav .menu-wrapper").removeClass('active');
    $("#nav .search-wrapper").removeClass('active');
});

$(".showSearch").click(function() {
    $("#nav .nav-overlay").addClass('active');
    $("#nav .search-wrapper").addClass('active');
    $("#nav .search-input input:eq(0)").focus();
});

$(".home").click(function(){
    var link = $(this).attr('href');
    window.location.href = link;
});

$("#nav .nav-overlay ul.menu li a").on('click', function(event){
    event.stopPropagation();
    //Cek apakah menu dengan submenu atau bukan
    var haveSubmenu = $(this).parent().children('ul').length;

    if(haveSubmenu){
        //Cek sudah terbuka atau belum
        var activated = $(this).parent().hasClass('active');

        if(activated){
            $(this).parent().parent().children('li').removeClass('active');
            $(this).parent().parent().children('li').removeClass('hidden');
        }else{
            $(this).parent().parent().children('li').removeClass('active');
            $(this).parent().parent().children('li').addClass('hidden');
            $(this).parent().addClass('active');
            $(this).parent().removeClass('hidden');
        }
    }else{
        var link = $(this).attr('href').split('/');
        console.log(link);
        if(link.length == 2){
            //Menu + Submenu
            var abstract = link[0]+".content";
            var pageId = link[1];
            $state.go(abstract, {
                pageId: pageId
            });
        }else{
            //Menu
            window.location.href = link[0];
        }
        //$scope.hideMenu();
    }
});
//Fixed Navigation
var offset = $("#nav-control").offset();
$("#nav-control").css({
    "position":"fixed",
    "top":offset.top,
    "left":offset.left
});
