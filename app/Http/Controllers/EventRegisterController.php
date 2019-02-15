<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class EventRegisterController extends Controller
{


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }



  /**
   * Display the specified resource.
   *
   * @param Event $event
   * @return \Illuminate\Http\Response
   */
  public function show($event) //todo add type hint
  {
    return view('event.register');
  }

  /**
   * Process an event registration.
   *
   * @param  \Illuminate\Http\Request $request
   * @param Event $event
   * @return \Illuminate\Http\Response
   */
  public function register(Request $request, Event $event) //TODO add type hint
  {
    dd($request->all());
    // validate
    // attempt to charge the card
    //if successful persist payment info, attendee info, and then send email to queue, display thank you page
    // else return them to the registration form with some error message
    return response($request->all(), 200);
  }

  /**
   * @param Event $event
   * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
   */
  public function registered($event) //todo add type hint
  {
    return response($event, 200);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
