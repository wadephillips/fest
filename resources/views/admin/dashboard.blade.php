@extends('voyager::master')


@section('content')
  <div class="container-fluid">
    @forelse($events as $event)
      <div class="row">
        <div class="col-md-3">
          <div class="card text-white bg-secondary mb-3">
            <div class="card-header m-3">
              <h4>{{$event->name}}</h4>
            </div>
            <div class="card-body">
              <table class="table">
                <thead>
                <tr>
                  <th>Registration Type</th>
                  <th>Attendees</th>
                </tr>
                </thead>
                <tbody>
                @forelse($event->getTotalRegistrationTypes() as $key => $values)
                  <tr>
                    <td><a
                          href="{{route('event.attendees.type', ['$event' => $event->slug,  'registration' => $key,])}}">{{$values['description']}}</a>
                    </td>
                    <td>{{$values['count']}}</td>
                  </tr>
                @empty
                  <tr>
                    <td>No registered attendees yet</td>
                  </tr>
                @endforelse
                <td scope="row"><strong>Total Attendees</strong></td>

                <td>{{$event->attendeeCount}}</td>
                </tr>
                </tbody>
              </table>

            </div>
          </div>
        </div>
        <!-- donors -->
        <div class="col-md-3" >
          <div class="card text-white bg-secondary">
            <div class="card-header"><h4>Donors</h4></div>
            <div class="card-body">
              @forelse($event->getModifierCount('poca_tech_donation') as $donors)
                <a href="{{route('event.donors', ['$event' => $event->slug,  'type' => $donors->key,])}}"><span class="badge badge-warning" id="poca-tech-donor-count">{{$donors->count}}</span>  {{$donors->description}}</a>
              @empty
                No donors yet
              @endforelse

            </div>
            <div class="card text-white bg-secondary mb-4">
              <div class="card-header"><h4>Linens</h4></div>
              <div class="card-body">
                @forelse(array_reverse($event->getModifierCount('linens')) as $linens)
                  <p>
{{--                    {{dd($linens)}}--}}
                    <a href="{{route('event.linens', ['$event' => $event->slug, 'type' => $linens->key, 'description' => $linens->description,])}}"><span class="badge badge-warning linens-count-badge">{{$linens->count}}</span>  {{$linens->description}}</a>
                  </p>
                @empty
                  No linens requested yet
                @endforelse
              </div>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="row">
        <h2>There no active events</h2>
      </div>
    @endforelse
  </div>
@endsection