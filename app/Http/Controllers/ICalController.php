<?php

namespace App\Http\Controllers;
use App\Goal;

class ICalController extends Controller
{
  
   /**
    * Gets the events data from the database
    * and populates the iCal object.
    *
    * @return void
    */
   public function getGoalsICalObject()
   {
       $goals = Goal::all();
       define('ICAL_FORMAT', 'Ymd\THis\Z');

       $icalObject = "BEGIN:VCALENDAR
       VERSION:2.0
       METHOD:PUBLISH
       PRODID:-//Jeremiah Iro//Goals//EN\n";
      
       // loop over events
       foreach ($goals as $goal) {
           $icalObject .=
           "BEGIN:VGOAL 
           DTSTART:" . date(ICAL_FORMAT, strtotime($goal->starts)) . "
           DTFINISH:" . date(ICAL_FORMAT, strtotime($goal->ends)) . "
           DTSTAMP:" . date(ICAL_FORMAT, strtotime($goal->created_at)) . "
           DESCRIPTOIN:$goal->description
           END:VGOAL\n";
       }

       // close calendar
       $icalObject .= "END:VCALENDAR";

       // Set the headers
       header('Content-type: text/calendar; charset=utf-8');
       header('Content-Disposition: attachment; filename="cal.ics"');
      
       $icalObject = str_replace(' ', '', $icalObject);
  
       echo $icalObject;
   }
}