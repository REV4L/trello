import { LCG } from './lcg.js';
import anime from './anime.es.js';

var b = false;

$(document).ready (function() {
    
      
    $("#o-insert-board").hide();

    

    
    $("#btn-create-board-overlay").click(function(event) {
        $("#username").val("");
        $("#description").val("");

        $("#title").text("New Board");
        $("#title").css("color", "white");

        $("#o-insert-board").fadeIn("slow");
        // return;
        // $("#o-insert-board").show();
    
    });
    $("#btn-cancel-create-board").click(function(event) {
        $("#o-insert-board").fadeOut("slow");
        // $("#o-insert-board").hide();
    
    });
    $("#btn-create-board").click(function(event) {

        event.preventDefault();
        
        var boardname = $("#i-boardname").val();
        var description = $("#i-description").val();

        if(boardname.length < 1) {
            $("#title").css("color", "pink");
            $("#title").text("Name empty!");
            return;
        }
        
        $.ajax({
            type: 'POST', // Use POST method for fetching data
            url: 'create_board.php', // The URL to your PHP script
            dataType: 'json', // Expect a JSON response
            data: {
                boardname: boardname,
                description: description
            },
            success: function(response) {
                $("#title").css("color", "white");
                $("#title").text(response.status);

                if(response.status == 'Name taken') {
                    $("#title").css("color", "red");
                    return;
                }

                getBoards();
                
                $("#o-insert-board").fadeOut("slow");

            },
            error:function(response) {
                $("#title").css("color", "red");
                $("#title").text(response.status);
                
                $("#o-insert-board").delay(2000).slideToggle();
                // return;
                // setTimeout(
                    //     function() 
                    //     {
                        //         $("#o-insert-board").hide();
                        //     }, 500);
            }       
        });

        // getBoards();

        // $("#o-insert-board").slideToggle();
        
        // event.preventDefault();

    });

    $("#btn-search").click(function(event) {
        search_filter();
    });
    
    getBoards();

    $('#search').on('input',function(e){
        search_filter();
    });

    requestAnimationFrame(updateLoop);
})

//////////////////////////////////////////////////////////////////////////////
var dt = 1.0 / 60;
var time = 0.0;
var lastTimestamp = performance.now();

function updateLoop(timestamp) {
    var elapsed = (timestamp - lastTimestamp) / 1000; // Convert to seconds
    lastTimestamp = timestamp;
    
    time += elapsed; // Increment time based on elapsed time scaled to 60 updates per second

    var len = $(".duplicate-this").length;

    $(".duplicate-this").each(function(index, element) {
        // 'element' is the DOM element, so we wrap it in a jQuery object
        var elem = $(element);
        
        var speed = 10;
        var t = time * speed;

        while(t > len) {t = t - len; }

        var bright = Math.abs(index - t*2);
        bright = Math.abs(index - t);

        if(bright > 1) bright = 0;
        else bright = 1;

        var bmult = 0.7;
        bright = 
        Math.max( // ker prie smoothly okol ko je pr zadnem
            1+ // normalno
            (
                Math.max(1-Math.abs(t - index)*0.1, 0) // 0.1 je feather
            )* bmult, // multiplier
            1+ // okol
            (
                Math.max(1-Math.abs((t-len) - index)*0.1, 0)
            )* bmult,
        );

        var loadSpeed = len;
        var opacity = (time*loadSpeed-index-1 > 0) ? 100 : 0;

        elem.find(".board-select-area").css('filter', 'saturate(' + (1 + Math.sin(time*4+index*777)*0.4) + ') ' + 'brightness(' + bright + ') ' + 'opacity(' + (opacity) + '%)');

    });

    requestAnimationFrame(updateLoop);
}
//////////////////////////////////////////////////////////////////////////////

function getBoards() {
    //alert("done");

    $.ajax({
        type: 'POST', // Use POST method for fetching data
        url: 'get_board_data.php', // The URL to your PHP script
        dataType: 'json', // Expect a JSON response
        success: function(response) {
            $('#dashboard').find(".duplicate-this").not(':last').remove();
            
            response.forEach(function(item, index) {
                if (typeof item.bname === 'undefined') return;

                var c = $(".duplicate-this").last().clone();
                c.prependTo("#dashboard");

                c.find(".title").text(item.bname);

                var rand = new LCG(item.bname+"thisisthebestsaltever");
                var hRotate = rand.next();

                c.css("filter", "hue-rotate("+ Math.round(hRotate*360/60)*60 + "deg) saturate(1)");
                c.css("display", "block");

                c.click(function(e){
                    e.preventDefault();
                });

                // da setta u session keri board naj gre, pol pa gre taj
                c.find('.open').click(function(e){
                    e.preventDefault();
                    $.ajax({
                        type: 'POST', // Use POST method for fetching data
                        url: 'session_select_board.php', // The URL to your PHP script
                        dataType: 'json', // Expect a JSON response
                        data: {
                            id: item.id
                        },
                        success: function(r) {
                            // c.text(r.status);
                            // c.text();
                            location.href = 'board.php';
                        }
                    });
                });

                c.find('.delete').click(function(e){
                    e.preventDefault();
                    $.ajax({
                        type: 'POST', // Use POST method for fetching data
                        url: 'delete_board.php', // The URL to your PHP script
                        dataType: 'json', // Expect a JSON response
                        data: {
                            boardId: item.id
                        },
                        success: function(response) {
                            getBoards();
                        }
                    });
                });
            });

            $("#btn-create-board-overlay").prependTo("#dashboard");
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('An error occurred while loadng boards: ' + error);
        }

        
    });

    // anime({
    //     targets: '.unselectable',
    //     translateX: 20,
    //     duration: 10,
    //     direction: 'alternate',
    //     autoplay: true,
    //     loop: true,
    //     delay: function(el, i, l) {
    //       return i * 100;
    //     },
    //     endDelay: function(el, i, l) {
    //       return (l - i) * 100;
    //     }
    // });


}

function search_filter() {
    var txt = $('#search').val().trim().toLowerCase(); // Get the search input, trim whitespace, and convert to lowercase
    console.log("Search text:", txt); // Debug: Log the search text

    var arr = $(".board-select-area");
    arr.each(function() {
        var element = $(this);
        var titleText = element.find(".title").text().trim().toLowerCase(); // Get the title text, trim whitespace, and convert to lowercase
        console.log("Title text:", titleText); // Debug: Log the title text

        if (txt === "" || titleText.includes(txt)) {
            console.log("Match found, displaying element."); // Debug: Log when a match is found
            element.css("display", "block");
        } else {
            console.log("No match, hiding element."); // Debug: Log when no match is found
            element.css("display", "none");
        }
    });
}