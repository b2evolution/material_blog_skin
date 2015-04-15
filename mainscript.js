(function($) {
    'use strict';
$('.circle-svg-a a, .circle-svg-span span').on("click", function(e) {
        var x = e.pageX;
        var y = e.pageY;
        var clickY = y - $(this).offset().top;
        var clickX = x - $(this).offset().left;
        var box = $(this);
        var setX = parseInt(clickX);
        var setY = parseInt(clickY);
        var radius = $(box).outerWidth() / 2;
        if ($(box).find("svg").length === 0) {
            $(box).append('<svg>\n\
                             <circle class="circle-1" cx="' + setX + '" cy="' + setY + '" r="' + (radius - 10) + '"></circle>'
                                    +'</svg>');
        }

        $(box).find('svg').css('opacity', '1');

        $(box).find('svg').animate({
            opacity: '0'
        }, {duration: 800, queue: false});

        var c1 = $(box).find(".circle-1");

        c1.attr('cx', setX);
        c1.attr('cy', setY);

        var addv = radius - 10;

        $(c1).animate({"r": radius}, {
            duration: 350,
            step: function(val) {
                c1.attr("r", (val + addv));
            }
        });

    });
    
    
 var panel_id = 0;
 
 $('.panel-group .panel').each(function(){
     panel_id++;
     
     $(this).find('.panel-toggle').attr('data-target', '.pcollapse-'+panel_id);
    
     $(this).find('.panel-toggle').addClass(' collapsed');
    
     $(this).find('.panel-collapse').addClass(' pcollapse-'+panel_id);
     
     
     if( $(this).find('.panel-heading').length > 0 ) {
         
          $(this).find('.panel-collapse').addClass(' collapse');
     }
     
 });
    
    
    
})(jQuery);