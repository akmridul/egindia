<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SearchMeetingController extends Controller
{

    public function uploadFile(Request $request) {

        $request->validate([
            'calendar_data' => 'required|max:2048|file', //|mimes:json
        ]);

        $file = $request->file('calendar_data');
        $folder = 'calendar_data_uploads';

        $filename = uniqid() . '_' . $file->getClientOriginalName();

        if(!$file->move(public_path($folder), $filename)) {
            return redirect()->route('search.meeting')->with('success', 'File uploaded successfully!');
        } else {
            return redirect()->back()->with('failure', 'File uploading failed. Please try again!');
        }        
    }

    public function searchMeeting(){        

        $CalendarData = array();

        $jsonDirectory = public_path('calendar_data_uploads');
        $jsonFiles = File::files($jsonDirectory);
        foreach ($jsonFiles as $jsonFile) {
            $jsonContents = file_get_contents($jsonFile);
            $jsonData = json_decode($jsonContents, true);

            array_push($CalendarData, $jsonData);
        }

        $calendarIds = array_column($CalendarData, 'timeslots');
        $mergedCalendarIds = array_merge(...$calendarIds);
        $uniqueCalendarIds = array_unique(array_column($mergedCalendarIds, 'calendar_id'));

        $timeslottypes = array_column($CalendarData, 'timeslottypes');
        $mergedtimeslottypes = array_merge(...$timeslottypes);
        $uniquetimeslottypes = array_unique(array_column($mergedtimeslottypes, 'id'));

        return view('searchmeeting')
               ->with('calendarIds', $uniqueCalendarIds)
               ->with('timeslottypes', $uniquetimeslottypes);

    }

    public function searchSubmit(Request $request){

        $request->validate([
            'nm_calendar_ids' => 'required',
            'nm_duration' => 'required|numeric',
            'nm_start_time' => 'required|date_format:H:i|before:nm_end_time',
            'nm_end_time' => 'required|date_format:H:i',
        ]);

        $CalendarData = array();

        $jsonDirectory = public_path('calendar_data_uploads');
        $jsonFiles = File::files($jsonDirectory);
        foreach ($jsonFiles as $jsonFile) {
            $jsonContents = file_get_contents($jsonFile);
            $jsonData = json_decode($jsonContents, true);

            array_push($CalendarData, $jsonData);
        }

        $startIntervalTime = $request->nm_start_time;
        $endIntervalTime = $request->nm_end_time;
        $duration = $request->nm_duration;
        $calendarIdsArray = $request->nm_calendar_ids;

        $availableSlotsByCalendar = [];

        foreach ($CalendarData as $calendar) {
            $calendarIdToSearch = $calendar['appointments'][0]['calendar_id'];

            $appointments = collect($calendar['appointments'])
                ->where('calendar_id', $calendarIdToSearch)
                ->toArray();
           
            $intervalStart = \Carbon\Carbon::parse($startIntervalTime);
            $intervalEnd = \Carbon\Carbon::parse($endIntervalTime);
            $interval = $intervalEnd->diffInMinutes($intervalStart);

            $timeSlots = [];
            for ($i = 0; $i <= $interval; $i += $duration) {
                $slotStart = $intervalStart->copy()->addMinutes($i);
                $slotEnd = $slotStart->copy()->addMinutes($duration);
                $timeSlots[] = [
                    'start' => $slotStart->toIso8601String(),
                    'end' => $slotEnd->toIso8601String(),
                ];
            }

            $bookedSlots = array_map(function ($appointment) {
                return [
                    'start' => $appointment['start'],
                    'end' => $appointment['end'],
                ];
            }, $appointments);

            $availableSlots = array_udiff($timeSlots, $bookedSlots, function ($slot1, $slot2) {
                return strcmp($slot1['start'], $slot2['start']);
            });
          
            $availableSlotsByCalendar[$calendarIdToSearch] = $availableSlots;
        }

        $resultArray = array_intersect_key($availableSlotsByCalendar, array_flip($calendarIdsArray));

        return view('meetingslots')->with('calendar_data', $resultArray);

    }

}
