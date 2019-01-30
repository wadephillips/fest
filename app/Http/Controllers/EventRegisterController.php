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
    return response($event, 200);
  }

  /**
   * Process an event registration.
   *
   * @param  \Illuminate\Http\Request $request
   * @param Event $event
   * @return \Illuminate\Http\Response
   */
  public function register(Request $request, $event) //TODO add type hint
  {
    return response($event, 200);
  }

  /**
   * @param Event $event
   * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
   */
  public function registered(Event $event) //todo add type hint
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
