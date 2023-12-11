@extends('layouts.template_mobile')
@section('title')
FMCG | About Us
@endsection
@section('content')
<div class="page-title-area">
  <div class="container">
      
      <div class="row">
      <div class="col-lg-12">
          
          
    <div class="page-title-content">
      <ul>
        <li> <a href="{{ route('home') }}"> Home </a> </li>
        <li class="active">{{ $about_us->title ?? ''}}</li>
      </ul>
    </div>
  </div>      </div></div>

  
</div>
<div class="about-area ptb-54 trms-and-condition innerp">
  <div class="container">
    <div class="about-content">
      <!--<h3>{{ $about_us->title  ?? ''}}</h3>-->
      
      <?php echo $about_us->page_content; ?>
     
     
     
     
     
     
     
     
     
     
    <div class="gap-30"></div>
  </div>
</div></div>
@endsection
