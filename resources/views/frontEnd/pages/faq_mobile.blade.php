@extends('layouts.template')
@section('title')
FMCG | About Us
@endsection
@section('content')





<?php ?>
 

<div class="about-area ptb-54 trms-and-condition ">
  
    <div class="about-content">
      <!--<h3>{{ $about_us->title  ?? ''}}</h3>-->
      <div class="container">
    <?php echo $faq->page_content; ?> 
     
    </div>
    <div class="gap-30"></div>
  </div>
</div><?php ?>

 
@endsection
