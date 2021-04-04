$('.events').css('display', 'none');
$('.main-collection-list').css('display', 'none');
$('.today-events').css('display', 'block');
$('#calendar').css('display', 'none');

$('.mcalendar').click(function () {
    $('.events').css('display', 'none');
    $('.today-events').css('display', 'none');
    $('.main-collection-list').css('display', 'none');
    $('.list-group-flush').empty();
    $('#calendar').css('display', 'block');
    $(this).addClass('active');
    $('.mtoday').removeClass('active');
    $('.mcollection').removeClass('active');
});

$('.mtoday').click(function () {
    $('.events').css('display', 'none');
    $('.main-collection-list').css('display', 'none');
    $('.list-group-flush').empty();
    $('.today-events').css('display', 'block');
    $('#calendar').css('display', 'none');
    $(this).addClass('active');
    $('.mcalendar').removeClass('active');
    $('.mcollection').removeClass('active');
    let today = new Date();
    let date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
    $.ajax({
        url: "todayEvents.php",
        type: "POST",
        data: {
            date: date
        },
        success: function (data, textStatus, jqXHR) {
            let json = JSON.parse(data);
            $('.today-events').empty();
            for (let e of json) {
                let event = $('<div></div>', { class: 'list-group-item list-group-item-action' });
                event.html(`<h4>${e[0]}</h4>
                    <h6>${e[1]}</h6>
                    &nbsp;${e[2]}<br>
                    &nbsp;Start : ${e[3]}&nbsp;&nbsp;&nbsp; End: ${e[4]}<br>
                `);
                let a = $('<a href="#"></a>', { class: 'list-group-item list-group-item-action' });
                a.on('click', () => {
                    let message = `${e[0]}:
                                    ${e[1]}
                                    ${e[2]}
                                    Start : ${e[3]} End: ${e[4]}`;
                    let form = $('<form></form>');
                    form.attr("method", "post");
                    form.attr("action", "send.php");
                    let mege = $(`<input/>`);
                    mege.attr("type", "hidden");
                    mege.attr("name", "message");
                    mege.attr("value", `${message}`);
                    form.append(mege);
                    $(document.body).append(form);
                    form.submit();
                });
                a.html('Send to a friend');
                event.append(a);
                $('.today-events').append(event);
            }


        }
    })
});
$(".mtoday").trigger("click");
$('.mcollection').click(async () => {
    $('.events').css('display', 'block');
    $('.main-collection-list').css('display', 'block');
    $('.today-events').css('display', 'none');
    $('#calendar').css('display', 'none');
    $(this).addClass('active');
    $('.mtoday').removeClass('active');
    $('.mcalendar').removeClass('active');

    let json = await getCollection();
    json = JSON.parse(json);
    $('.collection-list').empty();
    for (c of json) {
        let collection = $('<a></a>', { class: 'list-group-item list-group-item-action' });
        collection.html(`<h4>${c}</h4>`);
        collection.click(function () {
            let collectionName = $(this).text();
            $.ajax({
                url: "loadEvents.php",
                type: "POST",
                data: {
                    collection: collectionName
                },
                success: function (data, textStatus, jqXHR) {
                    let json = JSON.parse(data);
                    $('.list-group-flush').empty();
                    for (let e of json) {
                        let event = $('<li></li>', { class: 'list-group-item' });
                        event.html(`<h4>${e[0]}</h4>
                            <h6>${e[1]}</h6>
                            &nbsp;${e[2]}<br>
                            &nbsp;Start : ${e[3]}&nbsp;&nbsp;&nbsp; End: ${e[4]}<br>
                        `);
                        let a = $('<a href="#"></a>', { class: 'list-group-item list-group-item-action' });
                        a.on('click', () => {
                            let message = `${e[0]}:
                                            ${e[1]}
                                            ${e[2]}
                                            Start : ${e[3]} End: ${e[4]}`;
                            let form = $('<form></form>');
                            form.attr("method", "post");
                            form.attr("action", "send.php");
                            let mege = $(`<input/>`);
                            mege.attr("type", "hidden");
                            mege.attr("name", "message");
                            mege.attr("value", `${message}`);
                            form.append(mege);
                            $(document.body).append(form);
                            form.submit();
                        });
                        a.html('Send to a friend');
                        event.append(a);
                        $('.list-group-flush').append(event);
                    }
                }
            });
        });
        $('.collection-list').append(collection);
    }
}
);

$('.btn-cancel').click(function () {
    $('.form-insert').hide();
    $('.form-insert > form')[0].reset();
});
$('.btn-add').click(function () {
    let collection = $('#collectionList').val();
    if(collection == '' || !collection) 
    {
        $('#collectionList ~ span').text('Please choose a collection');
        $('#collectionList').addClass('is-invalid');
        return;
    }
    else{
        $('#collectionList').removeClass('is-invalid');
    }
    let event = $('#event').val();
    if(event == ''){
        $('#event ~ span').text('Please enter an event');
        $('#event').addClass('is-invalid');
        return;
    }else{
        $('#event').removeClass('is-invalid');
    }
    let disc = $('#description').val();
    if(disc == ''){
        $('#description ~ span').text('Please enter the description');
        $('#description').addClass('is-invalid');
        return;
    }else{
        $('#description').removeClass('is-invalid');
    }
    let visibale = $('#visibale').prop("checked");
    console.log(visibale);
    let start = $('#start').val();
    start = start.replace("T", " ");
    let end = $('#end').val();
    end = end.replace("T", " ");
    let json = {};
    json['title'] = collection;
    json['description'] = disc;
    json['event'] = event;
    json['start'] = start;
    json['end'] = end;
    json['visibale'] = visibale;
    console.log(json);
    json = JSON.stringify(json);
    $.ajax({
        url: "http://localhost:8080/insert.php",
        dataType: 'json',
        contentType: 'application/json',
        type: "POST",
        data: json,
        success: function (data) {
            calendar.fullCalendar('refetchEvents');
            alert('Added Successfully');
        },
        error: function (jqXhr, textStatus, errorThrown) {
            console.log(errorThrown);
            console.log(textStatus);
            console.log(jqXhr);
            console.log(jqXhr.responseText);
        }
    });
    calendar.fullCalendar('refetchEvents');
    $('.form-insert').hide();
    $('.form-insert > form')[0].reset();
});
$('.form-insert').hide();
async function getCollection() {
    const response = await fetch('./getCollection.php');
    return await response.text();
}

