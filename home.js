import { LCG } from './lcg.js';
import anime from './anime.es.js';

$(document).ready (function() {

    
    var rand = new LCG("thisisthebestsaltever");

    $('.duplicate-this').clone().appendTo(".scroll-R");
    $('.duplicate-this').clone().appendTo(".scroll-L");
    $('.duplicate-this').clone().appendTo(".scroll-R");
    $('.duplicate-this').clone().appendTo(".scroll-L");

    $('.duplicate-this').not().each(function(index, item) {
        var hRotate = rand.next();
        $(item).css("filter", "hue-rotate("+ Math.round(hRotate*360/60)*60 + "deg) saturate(1) opacity(30%)");
        
    });
});