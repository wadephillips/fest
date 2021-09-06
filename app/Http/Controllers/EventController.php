<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use function compact;
use function redirect;
use function secure_url;
use function view;

class EventController extends Controller
{

    /**
     * Handle requests to the index page.
     *
     * @return View|RedirectResponse|
     */
    public function index()
    {
        $events = Event::all()->where('active', '=', 1);

        if ($events->count() == 1) { // if there is only one event redirect to its detail page
            return redirect(secure_url('/events/'.$events[0]->slug));
        } else { // otherwise show a list of active events
            return view('events', compact('events'));
        }
    }


    /**
     * Display the specified event detail.
     *
     * @param  \App\Event  $event
     * @return View
     */
    public function show(Event $event)
    {
        $event->load(['breakouts.presenters', 'fees']);

        $presenters = $event->presenters;

        return view('event.index', compact('event', 'presenters'));
    }
}
