<?= $article['articles_content'] ?>
<div class="text-right mb-3 ">
    <a class="btn btn-primary" href="/city/events/create" title="Edit">Create Event</a>
</div>
<div class="allEventsCalendarContainer">
    <div id="eventsCalendar" class="calendar-container"></div>
    <div class="row justify-content-center">
        <div class="col-md-3 text-center">
            <a class="all-calendar" href="javascript:void(0);">Race Calendar</a>
        </div>
    </div>    
</div>
<div class="raceEventsCalendarContainer d-none">
    <div id="raceEventsCalendar" class="calendar-container"></div>
    <div class="row justify-content-center">
        <div class="col-md-3  text-center">
            <a class="race-calendar" href="javascript:void(0);">Show Calendar</a>
        </div>
    </div>    
</div>