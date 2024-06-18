import { LCG } from './lcg.js';
import { annotate, annotationGroup } from "https://unpkg.com/rough-notation?module";


$(document).ready (async function() {
    getUsers();
});

async function getUsers() {
    $('.duplicate-this').not(':last').remove();

    $.ajax({
        type: 'POST', 
        url: 'get_user_data.php',
        dataType: 'json', 
        data: {
            
        },
        success: function(response) {
            response.forEach(function(item, index) {
                var u = $('.duplicate-this').last().clone();

                u.find(".data").remove();

                var d = $('.data').last().clone();
                d.text(' id: ' + item.id);
                d.appendTo(u);

                var d = $('.data').last().clone();
                d.text(' | username: ' + item.username);
                d.appendTo(u);

                var d = $('.data').last().clone();
                d.text(' | email: ' + item.email);
                d.appendTo(u);

                u.css("display", "flex");
                u.appendTo(".content");

                u.find('.del').click(function(e) {
                    $.ajax({
                        type: 'POST', 
                        url: 'delete_user.php',
                        dataType: 'json', 
                        data: {
                            userId: item.id
                        },
                        success: function(response) {
                            location.reload()
                        }
                    });
                  
                  location.reload()
                });
            });
        }
    });
}