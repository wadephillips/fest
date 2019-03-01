@extends('layout')

@section('title', '')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm">
        <hero>
          <template slot="heading">
            POCA Event Registration
          </template>
          <template slot="lead">Some info goes here</template>
          <template slot="default">Et! Sit augue augue, sagittis aliquet? Urna integer enim, lorem lacus vel sagittis?
            Penatibus duis, risus, dapibus magnis turpis in adipiscing eu elementum, proin risus? Sit et egestas! In mus
            porttitor, odio massa! Mauris dictumst eros vel, ultrices porttitor? Tempor odio, mattis eu! Elementum
            dignissim in, proin tincidunt nunc.</template>
          <template slot="action"><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a> <a class="btn btn-warning btn-lg" href="#" role="button">Learn more</a></template>
        </hero>
      </div>
    </div>
  </div>
@endsection