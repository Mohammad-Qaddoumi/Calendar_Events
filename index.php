<?php

session_start();
session_regenerate_id(true);

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ./admin/login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Home</title>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" integrity="sha512-KXkS7cFeWpYwcoXxyfOumLyRGXMp7BTMTjwrgjMg0+hls4thG2JGzRgQtRfnAuKTn2KWTDZX4UdPg+xTs8k80Q==" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js" integrity="sha512-o0rWIsZigOfRAgBxl4puyd0t6YKzeAw9em/29Ag7lhCQfaaua/mDwnpE2PVzwqJ08N7/wqrgdjc2E0mwdSY2Tg==" crossorigin="anonymous"></script>

    <script src="calendarEvents.js"></script>
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="far fa-calendar-alt mr-2"></i>Calender Events</a>
            <div class="mflex d-flex flex-row bd-highlight mb-2">
                <h4 class="text-capitalize fs-3 mr-4 mt-2">
                    <i class="fas fa-user mr-2"></i>
                    <?php echo htmlspecialchars($_SESSION["username"]); ?>
                </h4>
                <div class="mflex btn-group" role="group" aria-label="Basic example">
                    <a href="./admin/reset-password.php" class="btn btn-warning">Profile</a>
                    <a href="./admin/logout.php" class="btn btn-danger">SignOut</a>
                </div>
            </div>
        </div>
    </nav>
    <main>
        <div class="list-group main-list">
            <a href="#" class="list-group-item list-group-item-action active mtoday">Todays Events</a>
            <a href="#" class="list-group-item list-group-item-action mcalendar">Calendar</a>
            <a href="#" class="list-group-item list-group-item-action mcollection">Collection</a>
        </div>
        <div class="list-stuff">
            <div id="calendar"></div>
            <div class="list-group today-events"></div>
            <div class="main-collection-list">
                <div class="collection-btn">
                    <button class="list-group-item btn btn-warning btn-add-collection">
                        <svg class="plusBtn" xml:space="preserve" viewBox="0 0 100 100" y="0" x="0" xmlns="http://www.w3.org/2000/svg" id="圖層_1" version="1.1" width="267px" height="267px" xmlns:xlink="http://www.w3.org/1999/xlink" style="width:100%;height:100%;background-size:initial;background-repeat-y:initial;background-repeat-x:initial;background-position-y:initial;background-position-x:initial;background-origin:initial;background-color:initial;background-clip:initial;background-attachment:initial;animation-play-state:paused">
                            <g class="ldl-scale" style="transform-origin:50% 50%;transform:rotate(0deg) scale(0.8, 0.8);animation-play-state:paused">
                                <circle stroke-miterlimit="10" stroke-width="8" stroke="#333" fill="none" r="40" cy="50" cx="50" style="stroke:rgb(223, 19, 23);animation-play-state:paused"></circle>
                                <path fill="#abbd81" d="M70.8 45.8H54.2V29.2c0-2.3-1.9-4.2-4.2-4.2s-4.2 1.9-4.2 4.2v16.5H29.2c-2.3 0-4.2 1.9-4.2 4.2s1.9 4.2 4.2 4.2h16.5v16.5c0 2.3 1.9 4.2 4.2 4.2s4.2-1.9 4.2-4.2V54.2h16.5c2.3 0 4.2-1.9 4.2-4.2s-1.7-4.2-4-4.2z" style="fill:rgb(7, 171, 204);animation-play-state:paused"></path>
                        </svg>
                        <h3>Add Collection</h3>
                    </button>
                </div>
                <div class="list-group collection-list">
                </div>
                <ul class="list-group list-group-flush events">
                </ul>
            </div>
        </div>
    </main>

    <div class="form-item" >

    </div>

    <div class="form-insert">
        <form>
            <div class="form-group">
                <label for="sel1" class="mainContant">
                    <div>Collection</div>
                    <input type="button" class="btn btn-warning btn-cancel" value="X">
                </label>
                <select class="form-control" id="collectionList">
                </select>
                <span class="invalid-feedback"></span>
            </div>
            <div class="form-group">
                <label>Event</label>
                <input type="text" id="event" class="form-control">
                <span class="invalid-feedback"></span>
            </div>
            <div class="form-group">
                <label>Description</label>
                <input type="text" id="description" class="form-control">
                <span class="invalid-feedback"></span>
            </div>
            <div class="form-group">
                <label for="start">Start date:</label>
                <input type="datetime-local" id="start" value="2021-07-22T19:30" min="2000-01-01T00:00" max="2030-12-31T00:00">
            </div>
            <div class="form-group">
                <label for="end">End date:</label>
                <input type="datetime-local" id="end" value="2021-07-22T19:30" min="2000-01-01T00:00" max="2030-12-31T00:00">
            </div>
            <div class="checkbox">
                <label><input id="visibale" type="checkbox" value="">&nbsp;&nbsp;Visibale</label>
            </div>
            <div class="form-group">
                <input type="button" class="btn btn-primary btn-add" value="Add">
            </div>
        </form>
    </div>




    <script src="userdata.js"></script>
    <link rel="stylesheet" href="style2.css">

</body>

</html>