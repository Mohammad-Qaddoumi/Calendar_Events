let calendar;
$(function(){
    calendar = $('#calendar').fullCalendar({
        editable: true,
        header:{
            left: 'prev,next,today',
            center: 'prevYear title nextYear',
            right:'month,agendaWeek,agendaDay'
        },
        events:'load.php',
        selectable: true,
        selectHelper: true,
        select: async (start,end,allDay) => {
            let form = $('.form-insert');
            form.show();
            $('#collectionList').empty();
            let json = await getCollection();
            json = JSON.parse(json);
            let defaultOptions = $('<option></option>');
            defaultOptions.text('Choose your Collection');
            defaultOptions.val("");
            defaultOptions.attr('disabled','disabled');
            defaultOptions.attr('selected', 'selected');
            $('#collectionList').append(defaultOptions);
            for(c of json){
                let option = $('<option></option>');
                option.text(c);
                option.val(c);
                $('#collectionList').append(option);
            }
            let mStart = datetimeformate($.fullCalendar.formatDate(start,"YYYY-MM-DD HH:mm:ss"));
            let mEnd = datetimeformate($.fullCalendar.formatDate(end,"YYYY-MM-DD HH:mm:ss"));
            $('#start').val(mStart);
            $('#end').val(mEnd);
        },
        editable : true,
        eventResize : function(e){
            let json ={};
            json['title'] = e.title;
            json['start'] = $.fullCalendar.formatDate(e.start,"YYYY-MM-DD HH:mm:ss");
            json['end'] =  $.fullCalendar.formatDate(e.end,"YYYY-MM-DD HH:mm:ss");
            json['id'] = e.id;
            json = JSON.stringify(json);
            $.ajax({
                url: "update.php",
                type: "POST",
                data: json,//{title: e.title,start: start,end: end,id: id},
                success: function(){
                    alert('Event updated');
                }                                
            });
            calendar.fullCalendar('refetchEvents');
        },
        eventDrop: function(e){
            let json ={};
            json['title'] = e.title;
            json['start'] = $.fullCalendar.formatDate(e.start,"YYYY-MM-DD HH:mm:ss");
            json['end'] =  $.fullCalendar.formatDate(e.end,"YYYY-MM-DD HH:mm:ss");
            json['id'] = e.id;
            json = JSON.stringify(json);
            $.ajax({
                url: "update.php",
                type: "POST",
                data: json,//{title: e.title,start: start,end: end,id: id},
                success: function(){
                    alert('Event updated');
                }                                              
            });
            calendar.fullCalendar('refetchEvents');
        },
        eventClick: function(e){
            if(confirm('Are you sure you want to remove it?'))
            {
                let id =e.id;
                $.ajax({
                    url: "delete.php",
                    type: "POST",
                    data:{id:id},
                    success: function(){
                        calendar.fullCalendar('refetchEvents');
                        alert('Event Removed');
                    }
                })
            }

        }
    });

});

function datetimeformate(dateString){
    var dateVal = new Date(dateString);
    var day = dateVal.getDate().toString().padStart(2, "0");
    var month = (1 + dateVal.getMonth()).toString().padStart(2, "0");
    var hour = dateVal.getHours().toString().padStart(2, "0");
    var minute = dateVal.getMinutes().toString().padStart(2, "0");
    var sec = dateVal.getSeconds().toString().padStart(2, "0");
    var ms = dateVal.getMilliseconds().toString().padStart(3, "0");
    return dateVal.getFullYear() + "-" + (month) + "-" + (day) + "T" + (hour) + ":" + (minute) + ":" + (sec) + "." + (ms);
}
