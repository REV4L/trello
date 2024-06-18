import { LCG } from './lcg.js';
import { annotate, annotationGroup } from "https://unpkg.com/rough-notation?module";



var b = false;

var boardId = -1;

$(document).ready (async function() {
    $("#o-inspect-task").hide();

    $("#btn-close-inspect-task").click(function(e) {
        $("#o-inspect-task").fadeOut("slow");
    });

    // $("#o-inspect-task").find('textarea').on('input',function(e){
    //     $.ajax({
    //         type: 'POST', 
    //         url: 'update_task_description.php',
    //         dataType: 'json', 
    //         data: {
    //             taskId: $("#o-inspect-task").data('editId') ?? -1,
    //             taskDescription: $("#o-inspect-task").find('textarea').val()
    //         },
    //     });
    // });

    $("#o-inspect-task").find('#btn-delete-task').click(function(e){
        $.ajax({
            type: 'POST', 
            url: 'delete_task.php',
            dataType: 'json', 
            data: {
                taskId: $("#o-inspect-task").data('editId') ?? -1,
            },
            success: function(response) {
                $("#o-inspect-task").fadeOut("slow");
                getLists();
            }
        });
    });

    $("#btn-create-list").click(function(event) {
        $.ajax({
            type: 'POST', // Use POST method for fetching data
            url: 'create_list.php', // The URL to your PHP script
            dataType: 'json', // Expect a JSON response
            data: {
                boardId: boardId
            },
            success: function(response) {
                // alert(response['status']);
                getLists();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Error: " + textStatus + ", " + errorThrown);
                // console.log("Response Text: " + jqXHR.responseText);
            }
        });
    });

    for(var i = 0; i < 10; i++) {
        var c = $(".board-list-area").first().clone();
        c.find("#title1").text("List " + (i+2));
        c.appendTo("#board");
    }

    // $('.board-list-item').each(function(index, element) {
        // annotate(element, { type: 'strike-through', color: 'red' }).show();
    // });

    await $.ajax({
        type: 'POST', // Use POST method for fetching data
        url: 'get_session_var.php', // The URL to your PHP script
        dataType: 'json', // Expect a JSON response
        data: {
            varname: 'selectedBoardId'
        },
        success: function(response) {
            boardId = response['value'];
            // alert("dett je " + response.value);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert("Error: " + textStatus + ", " + errorThrown);
            // console.log("Response Text: " + jqXHR.responseText);
        }
    });

    getLists();
    
    //alert("boardId je " + boardId);
})

async function getLists() {
    //alert("done");

    if(boardId < 0) location.href = "dashboard.php";

    await $.ajax({
        type: 'POST', 
        url: 'get_list_data.php', 
        dataType: 'json', 
        data: {
            selectedBoardId: boardId
        },
        success: function(response) {
            $('#board').find(".list").not(':last').remove();
            response.forEach(function(item, index) {
                if (typeof item.name === 'undefined') return;

                var c = $(".list").last().clone();
                c.prependTo("#board");

                // c.find(".title").text(item.name + " " + item.id);

                c.find(".board-list-item").remove();

                c.find('.title').first().val(item.name);

                c.find('.title').first().on('input',function(e){
                    $.ajax({
                        type: 'POST', 
                        url: 'update_list_name.php',
                        dataType: 'json', 
                        data: {
                            listId: item.id,
                            listName: c.find('.title').first().val()
                        },
                    });
                });

                c.find('.del').first().click(function(e) {
                    $.ajax({
                        type: 'POST', 
                        url: 'delete_list.php',
                        dataType: 'json', 
                        data: {
                            listId: item.id,
                        },
                        success: function(response) {
                            c.remove();
                        }
                    });
                });

                // c.find('.task-more').first().click(function(e) {
                //     $("#o-inspect-task").fadeIn("slow");
                // });

                item.tasks.forEach(function(item2, index2) {
                    var t = $(".board-list-item").last().clone();
                    t.css("display", "block");
                    t.appendTo(c.find('.board-list').first());
                    t.data('taskId', item2.id);
                    t.data('complete', item2.complete);

                    // console.log( t.data('complete'));

                    t.find('input').last().val(item2.name);
                    t.find('input').last().on('input',function(e){
                        $.ajax({
                            type: 'POST', 
                            url: 'update_task_name.php',
                            dataType: 'json', 
                            data: {
                                taskId: item2.id,
                                taskName: t.find('input').last().val()
                            },
                        });
                    });

                    

                    var annotation = annotate(t.find('input')[0], { type: 'strike-through', color: 'red' });

                    annotation = null;

                    if(t.data('complete') == 1) {
                        // t.each(function(i, elem) {
                        //annotation.show();
                        // })


                        t.find('input').css("color", "rgb(97, 97, 143)");
                        t.find('input').css("text-decoration" ,"line-through");
                        t.find('input').prop('readonly', 'true');
                        t.css("filter", "opacity(50%)");
                        t.find('.complete').css("color", "lime");
                    } else {
                        // t.find('input').css("color", "green");
                    }

                    t.find('.task-inspect').click(async function(e) {
                        $("#o-inspect-task").data("editId", item2.id);

                        await $.ajax({
                            type: 'POST', 
                            url: 'get_task_data.php',
                            dataType: 'json', 
                            data: {
                                taskId: item2.id
                            },
                            success: function(response) {
                                $("#o-inspect-task").find('textarea').val(response.description);

                                $("#o-inspect-task").find('.huge-title').html(response.name);
                                
                            }
                        });
                        
                        // unbinda event bajde
                        $("#o-inspect-task").find('textarea').off("input");

                        $("#o-inspect-task").find('textarea').on('input',function(e){
                            $.ajax({
                                type: 'POST', 
                                url: 'update_task_description.php',
                                dataType: 'json', 
                                data: {
                                    taskId: item2.id,
                                    taskDescription: $("#o-inspect-task").find('textarea').val()
                                },
                            });
                        });

                        
                        $("#o-inspect-task").fadeIn("slow");
                        // console.log('dett');
                    });

                    t.find('.complete').click(async function(event){
                        var complete_ = 0;
                        if(t.data('complete') == null) complete_ = 1;
                        else if(t.data('complete') == 1) complete_ = 0;
                        else
                            complete_ = 1;

                        // console.log(complete_);
                        await $.ajax({
                            type: 'POST', 
                            url: 'update_task_complete.php', 
                            dataType: 'json', 
                            data: {
                                taskId: item2.id,
                                complete: complete_
                            },
                            success: function(response) {
                            }
                        });
                        t.data('complete', complete_);
                        if(t.data('complete') == 1) {
                            annotation?.show();
                            t.css("filter", "opacity(50%)");
                            t.find('input').css("color", "rgb(97, 97, 143)");
                            t.find('input').css("text-decoration" ,"line-through");
                            t.find('.complete').css("color", "lime");
                        }
                        if(t.data('complete') == 0) {
                            annotation?.hide();
                            t.removeAttr("style");
                            t.find('.complete').removeAttr("style");
                            t.find('input').removeAttr("style");
                            t.find('input').css("text-decoration" ,"none");
                        }

                        t.find('input').prop('readonly', complete_);
                    });
                });

                c.find('.addTask').click(async function(event) {
                    await $.ajax({
                        type: 'POST', 
                        url: 'create_task.php',
                        dataType: 'json', 
                        data: {
                            boardId: boardId,
                            listId: item.id
                        },
                    });
                    getLists();
                });

                // var rand = new LCG(item.name+"thisisthebestsaltever");
                // var hRotate = rand.next();

                // c.css("filter", "hue-rotate("+ Math.round(hRotate*360/60)*60 + "deg) saturate(1)");
                c.data('listId', item.id);
                c.css("display", "block");

            });

            $("#btn-create-list").prependTo("#board");
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('An error occurred while loadng boards: ' + error);
        }

        
    });

    $("ul").sortable({
        stop: function (e) {
            var orderedLists = [];
            var orderedListIds = [];

            $('.board-list').each(function(index, item) {
                if(typeof $(item).parent().data('listId') !== 'undefined') {
                    orderedLists.push($(item).parent().data('listId'));
                    orderedListIds.push(index);
                    // console.log("list " + index + ". : " + $(item).parent().data('listId'));
                }
            });

            $.ajax({
                type: 'POST', 
                url: 'update_list_order.php',
                dataType: 'json', 
                data: {
                    // previusListId: previusListId,
                    listIds: orderedLists,
                    listOrders: orderedListIds
                },
                success: function(response) {
                    // getLists();
                    // alert(response['status']);
                },
                error: function(e) {
                    alert("update list order error");
                }

            });
        }
    });
    $(".board-list").sortable({
        connectWith: ".board-list",
        placeholder: "drop-preview",
        stop:  async function(event, ui) { //recieve ce gre u drug list, ce pa u istem uporab stop:
            
            // var previusList = 
            var previusListId = ui.item.data('listId');
            var newListId = ui.item.parent().parent().data('listId');

            var taskId = ui.item.data('taskId');

            // alert(ui.item.parent('.list') + " " +  newListId + " " + taskId);
            // ui.item.parent().remove();
            // ui.item.parent('.list').remove();
            // ui.item.parent().parent().remove();

            await $.ajax({
                type: 'POST', 
                url: 'update_task_list_id.php',
                dataType: 'json', 
                data: {
                    // previusListId: previusListId,
                    newListId: newListId,
                    taskId: taskId
                },
                success: function(response) {
                    // getLists();
                    // console.log("new list id: " + newListId + " task id: " + taskId);
                },
                error: function(e) {
                    // console.log("new list id: " + newListId + " task id: " + taskId);
                    alert("couldnt update task listId");
                }

            });

            var orderedLists = [];
            var orderedListIds = [];
            var orderedTasks = [];
            var orderedTasksIds = [];

            $('.board-list').each(function(index, item) {
                if(typeof $(item).parent().data('listId') !== 'undefined') {
                    orderedLists.push($(item).parent().data('listId'));
                    orderedListIds.push(index);
                    // console.log("list " + index + ". : " + $(item).parent().data('listId'));

                    $(item).find('.board-list-item').each(function(index2, item2) {
                        orderedTasks.push($(item2).data('taskId'));
                        orderedTasksIds.push(index2);
                        // console.log("task " + index2 + ". : " + $(item2).data('taskId'));
                    });
                }
            });
            
            // shrani orderje
            // SQL ajax to order tasks
            await $.ajax({
                type: 'POST', 
                url: 'update_task_order.php',
                dataType: 'json', 
                data: {
                    // previusListId: previusListId,
                    taskIds: orderedTasks,
                    taskOrders: orderedTasksIds
                },
                success: function(response) {
                    // getLists();
                    // alert(response['status']);
                },
                error: function(e) {
                    alert("update task order error");
                }

            });
            //

            // SQL ajax to order boards

            await $.ajax({
                type: 'POST', 
                url: 'update_list_order.php',
                dataType: 'json', 
                data: {
                    // previusListId: previusListId,
                    listIds: orderedLists,
                    listOrders: orderedListIds
                },
                success: function(response) {
                    // getLists();
                    // alert(response['status']);
                },
                error: function(e) {
                    alert("update list order error");
                }

            });

            // tule ce ne updejta notation
            getLists();


        }
    }).disableSelection();

}


/*

    <?php

    $host = "localhost";
    $user = "ozim_admin";
    $password = "geslo";
    $db = "ozim_trello1";

    //1. way
    //$con = mysqli_connect($host, $user, $password) or die("Napaka pri povezavi na streznik!");

    //echo 'STREZNIK ✔️<br><br>';

    //$db = "proizvodi";

    //mysqli_select_db($con, $db) or die ("Napaka pri povezani na bazo!");

    //echo 'BAZA ✔️';

    //2. way

    try{
        $link = new mysqli($host, $user, $password, $db);

        //echo 'Status: dela<br><br>';

    }catch(Exception $e){
        echo 'Status: db error <br><br>';
    }
   
    //POVEZALI juhu

    mysqli_set_charset($link, "utf8");


    ?>
    */