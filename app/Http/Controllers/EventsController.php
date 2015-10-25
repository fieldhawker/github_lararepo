<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Events;

class EventsController extends Controller
{

    protected $events;
    private   $page_limit = 100;

    /**
     * @param Events $events
     */
    public function __construct(Events $events)
    {
        $this->events = $events;
    }

    public function getIndex(Request $request)
    {
        $data = $request->all();

        $query = $this->events->query();

        if (isset($data['title']) && $data['title']) {

            $query->where('title', 'like', '%' . $data['title'] . '%');

        }

        $events = $query->where("status", "1")->OrderBy("start_date", "desc")->paginate($this->page_limit);

        return view('events.index')->with(compact('events'));
    }

}
