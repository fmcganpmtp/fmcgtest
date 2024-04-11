@extends('layouts.template')
@section('title', 'Seller Profile')
@section('content')



<section class="my-prof-new">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="prf-out-c11">
          <div class="profile-Container">
            <div class="cover-c">
              <div class="cover-image"><img src="assets/images/cover-image.jpg"></div>
              <div class="pro-img-row">
                <div class="row">
                  <div class="col-lg-4 col-12">
                    <div class="prof-imgg"><img src="assets/images/pro-f-image.jpg"></div>
                  </div>
                  <div class="col-lg-8 col-12"> <a href="#" class="greenButton">Edit</a> </div>
                </div>
              </div>
            </div>
            <div class="prof-inner-C">
              <div class="pro-basic-info">
                <h2>Uji Foods<img src="assets/images/grenn-varified.png" class="varified-ic"></h2>
                <h3>Private Label</h3>
                <h4>Sofr Drinks</h4>
              </div>
              <div class="pr-adrrs-blk">
                <div class="row">
                  <div class="col-lg-4 col-12">
                    <ul class="bsc-inf">
                      <li class="inf"><a href="mailt:info@ujifoods.com">info@ujifoods.com</a></li>
                      <li class="tl"><a href="tel:+919888211125">+919888211125</a></li>
                      <li class="wb"><a href="www.ujifoods.com" target="_blank">www.ujifoods.com</a></li>
                    </ul>
                  </div>
                  <div class="col-lg-4 col-12">
                    <ul class="prf-adr">
                      <li>Sector 35,</li>
                      <li>Chandigarh,</li>
                      <li>India</li>
                    </ul>
                  </div>
                  <div class="col-lg-4 col-12">
                    <ul class="prf-count">
                      <li>
                        <h6>326</h6>
                        Profile Views</li>
                      <li>
                        <h6>154</h6>
                        Network Connections</li>
                      <li>
                        <h6>5+</h6>
                        Products</li>
                    </ul>
                  </div>
                </div>
              </div>
              <!--tab-->
              <div class="prf-tab-sec">
                <div class="pr-tab-menu">
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" " id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">About</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Products</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Regions</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link   id="contact-tab1" data-bs-toggle="tab" data-bs-target="#contact1" type="button" role="tab" aria-controls="contact1" aria-selected="false "> Employees </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link " id="contact-tab2" data-bs-toggle="tab" data-bs-target="#contact2" type="button" role="tab" aria-controls="contact2" aria-selected="false">My profiles</button>
                    </li>
                  </ul>
                  <a href="#" class="greenButton">Edit</a> </div>
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active " id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row pr-row">
                      <div class="col-lg-6 col-12">
                        <div class="prf-abt-txt">
                          <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer</p>
                          <p> took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. ook a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing softwar It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software </p>
                          <p>like Aldus PageMaker incl luding versions of Lorem Ipsum.Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.</p>
                        </div>
                      </div>
                      <div class="col-lg-6 col-12">
                        <div class="cmpny-prof"><img src="assets/images/company-prof-1.jpg"></div>
                        <div class="cmpny-prof"><img src="assets/images/company-prof-2.jpg"></div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="row">
                      <?php for($i=1;$i<=8;$i++)
{ ?>
                      <div class="col-lg-4 col-12"> <a href="https://hermosoftech-projects.in/fmcg/public/user-product-detail/4698 ">
                        <div class="product-thumbnail hovereffect">
                          <div class="pro-img"> <img src="https://hermosoftech-projects.in/fmcg/public/uploads/productImages/1675228641_images.jpg"> </div>
                          <div class="product-title">
                            <h3> Mixers </h3>
                            <h4> $&nbsp;999 
                              (Price Negotiable) </h4>
                            <div class="pro-no-loc">
                              <h5> <i class="fa fa-map-marker" aria-hidden="true"></i> India </h5>
                            </div>
                          </div>
                        </div>
                        </a> </div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="tab-pane fade " id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
                    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
                    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
                    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
                    <div id="chartdiv"></div>
					
					
                    <div class="map-descrip">
                      <div class="row">
                        <div class="col-lg-6 col-12">
                          <h3><b class="rg-active"></b>Regions we are active in</h3>
                          
						  
						  <div class="country-list">
						  <div class="row">
						  	<div class="col-lg-6 col-12">
							<h4>Europe</h4>
							</div>
							
							<div class="col-lg-6 col-12">
							<ul>
                                <li>Tronce</li>
                                <li>Spain</li>
                              </ul>
							</div>
						  </div>
						 </div>
						  
						  
						  
						  
						   <div class="country-list">
						  <div class="row">
						  	<div class="col-lg-6 col-12">
							<h4>Middle East`</h4>
							</div>
							
							<div class="col-lg-6 col-12">
							 <ul>
                                <li>Soudia Arabia</li>
                                <li>Omar</li>
                                <li>Juron</li>
                              </ul>
							</div>
						  </div>
						 </div>
						  
						  
						  <div class="country-list">
						  <div class="row">
						  	<div class="col-lg-6 col-12">
							<h4>Asia</h4>
							</div>
							
							<div class="col-lg-6 col-12">
							 <ul>
                              <li>Indic</li>
                              <li>Bangladesh </li>
                            </ul>
							</div>
						  </div>
						 </div>
						  
						  
                        </div>
						
						
						<div class="col-lg-6 col-12">
                          <h3><b class="exp"></b>Regions we would like to expand to</h3>
                          <div class="country-list">
						  <div class="row">
						  	<div class="col-lg-6 col-12">
							<h4>Europe</h4>
							</div>
							
							<div class="col-lg-6 col-12">
							<ul>
                                <li>Tronce</li>
                                <li>Spain</li>
                              </ul>
							</div>
						  </div>
						 </div>
						  
						  
						  
						  
						   <div class="country-list">
						  <div class="row">
						  	<div class="col-lg-6 col-12">
							<h4>Middle East`</h4>
							</div>
							
							<div class="col-lg-6 col-12">
							 <ul>
                                <li>Soudia Arabia</li>
                                <li>Omar</li>
                                <li>Juron</li>
                              </ul>
							</div>
						  </div>
						 </div>
						  
						  
                          </ul>
                        </div>
						
                      </div>
                    </div>
					
					
					
                  </div>
                  <div class="tab-pane fade " id="contact1" role="tabpanel" aria-labelledby="contact-tab1">
                    <div class="row">
                      <div class="col-lg-6 col-12">
                        <div class="prf-inner">
                          <div class="tab-prf-image"><img src="assets/images/chat-02.jpg"></div>
                          <ul class="bsc-inf">
                            <li class="us-nam"><a href="#">Giovanni Lalaiui</a></li>
                            <li class="des"><a href="#">senior sales representative</a></li>
                            <li class="inf"><a href="mailt:info@ujifoods.com">info@ujifoods.com</a></li>
                            <li class="tl"><a href="tel:+919888211125">+919888211125</a></li>
                          </ul>
                        </div>
                      </div>
                      <div class="col-lg-6 col-12">
                        <div class="tab-prf-image"><img src="assets/images/chat-02.jpg"></div>
                        <ul class="bsc-inf">
                          <li class="us-nam"><a href="#">Giovanni Lalaiui</a></li>
                          <li class="des"><a href="#">senior sales representative</a></li>
                          <li class="inf"><a href="mailt:info@ujifoods.com">info@ujifoods.com</a></li>
                          <li class="tl"><a href="tel:+919888211125">+919888211125</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade " id="contact2" role="tabpanel" aria-labelledby="contact-tab2">
                    <div class="pr-tab-inner">
                      <div class="row">
                        <div class="col-lg-3 col-12">
                          <div class="tab-profile-user-img"><img src="assets/images/juan.jpg"></div>
                        </div>
                        <div class="col-lg-9 col-12">
                          <ul class="bsc-inf">
                            <li class="us-nam"><a href="#">Giovanni Lalaiui</a></li>
                            <li class="des"><a href="#">senior sales representative</a></li>
                            <li class="inf"><a href="mailt:info@ujifoods.com">info@ujifoods.com</a></li>
                            <li class="tl"><a href="tel:+919888211125">+919888211125</a></li>
                          </ul>
                        </div>
                      </div>
                      <div class="ch-pwd">
                        <h3>Change Password</h3>
                        <div class="row">
                          <div class="col-lg-4 col-12">
                            <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label">Current Password</label>
                              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                          </div>
                          <div class="col-lg-4 col-12">
                            <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label">New Password</label>
                              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                          </div>
                          <div class="col-lg-4 col-12">
                            <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label">Confirm Password</label>
                              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-8 col-12"></div>
                          <div class="col-lg-4 col-12">
                            <button type="button" class="blue-button">Update Password</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="pro-lft-widget">
          <div class="widget-sidebar">
            <div class="sidebar-widget  borddr-bx1 categories tpp">
              <div class="filter-cat">
                <h3>Search by Keyword</h3>
                <div class="autocomplete form-group sg-list">
                  <div class="srch-left-3">
                    <input type="text" name="keyword" id="search_keyword" class="form-control" placeholder="Search">
                    <input type="hidden" name="topcategorysearch" id="topcategorysearch" value="Food1-2307041688473563">
                    <button type="submit" class="search_keyword_icon"><i class="fa fa-search" aria-hidden="true"></i></button>
                  </div>
                </div>
              </div>
              <div class="filter-cat">
                <h3>Search by Location</h3>
                <div class="autocomplete form-group sg-list">
                  <div class="srch-left-3">
                    <div class="form-group">
                      <select type="text" placeholder="Select Category"  class="form-control">
                        <option value="">Indian</option>
                        <option value="680" selected="">UK</option>
                        <option value="435">UAW</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="filter-cat">
                <h3>Search by Keyword</h3>
                <div class="autocomplete form-group sg-list">
                  <div class="srch-left-3">
                    <input type="text" name="keyword" id="search_keyword" class="form-control" placeholder="Search">
                    <input type="hidden" name="topcategorysearch" id="topcategorysearch" value="Food1-2307041688473563">
                    <button type="submit" class="search_keyword_icon"><i class="fa fa-search" aria-hidden="true"></i></button>
                  </div>
                </div>
              </div>
              <div class="filter-cat">
                <h3>Search by Brand</h3>
                <div class="autocomplete form-group sg-list">
                  <div class="srch-left-3">
                    <input type="text" name="keyword" id="search_keyword" class="form-control" placeholder="Search">
                    <input type="hidden" name="topcategorysearch" id="topcategorysearch" value="Food1-2307041688473563">
                    <button type="submit" class="search_keyword_icon"><i class="fa fa-search" aria-hidden="true"></i></button>
                  </div>
                </div>
              </div>
              <div class=" price-ranger01">
                <h3>Filter By Price</h3>
                <div class="inner-margin">
                  <div class="grey_slide" style="display:none;"> <img src="https://hermosoftech-projects.in/fmcg/public/images/grey_slid.jpg"> </div>
                  <div class="price-fi-out"> <span class="irs irs--round js-irs-0"><span class="irs"><span class="irs-line" tabindex="0"></span><span class="irs-min" style="visibility: hidden;">0</span><span class="irs-max" style="visibility: hidden;">1000000</span><span class="irs-from" style="visibility: visible; left: 1.18606%;">0</span><span class="irs-to" style="visibility: visible; left: 83.0754%;">1000000</span><span class="irs-single" style="visibility: hidden; left: 36.4783%;">0 — 1000000</span></span><span class="irs-grid"></span><span class="irs-bar" style="left: 4.58891%; width: 90.8222%;"></span><span class="irs-shadow shadow-from" style="display: none;"></span><span class="irs-shadow shadow-to" style="display: none;"></span><span class="irs-handle from" style="left: 0%;"><i></i><i></i><i></i></span><span class="irs-handle to" style="left: 90.8222%;"><i></i><i></i><i></i></span></span>
                    <input type="text" id="p-range" class="js-range-slider irs-hidden-input" name="my_range" value="" data-skin="round" data-type="double" data-min="0" data-max="1000000" block="true" disable="true" tabindex="-1" readonly="">
                  </div>
                  <div class="row price-fliter-Box">
                    <div class="col-lg-6 col-12">
                      <label>Price From :</label>
                      <input type="text" id="p-start" placeholder="0" onBlur="range_selfupdate()" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="price_from">
                    </div>
                    <div class="col-lg-6 col-12">
                      <label>Price To :</label>
                      <input type="text" id="p-end" placeholder="1000000" onBlur="range_selfupdate()" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="price_to">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6 col-12">
                      <label>
                      <input type="radio" class="chkPriceFilter rad1" id="p-req-both" name="priceOnRequest" value="2" style="width:auto !important;" data-waschecked="false">
                      &nbsp;Price Only</label>
                    </div>
                    <div class="col-lg-6 col-12">
                      <label>
                      <input type="radio" class="chkPriceFilter rad2" id="p-req-only" name="priceOnRequest" value="1" style="width:auto !important;">
                      &nbsp;Price on Request</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="filter-cat">
                <h3>Search by Best Before Use</h3>
                <div class="autocomplete form-group sg-list">
                  <div class="srch-left-3">
                    <input type="text" name="keyword" id="search_keyword" class="form-control" placeholder="Search">
                    <input type="hidden" name="topcategorysearch" id="topcategorysearch" value="Food1-2307041688473563">
                    <button type="submit" class="search_keyword_icon"><i class="fa fa-search" aria-hidden="true"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <script src="https://hermosoftech-projects.in/fmcg/public/js/io_range-slider.min.js"></script>
        <link rel="stylesheet" href="https://hermosoftech-projects.in/fmcg/public/css/io_rangeslider.css">
        <link rel="stylesheet" href="https://hermosoftech-projects.in/fmcg/public/css/select2.min.css">
      </div>
    </div>
  </div>
  <!--container-->
</section>


<script> 
$fmcg(document).ready(function(){
 $fmcg(".nav-link").click(function(){ 
    $fmcg(".pro-lft-widget").hide();
  });
  $fmcg("#profile-tab").click(function(){ 
    $fmcg(".pro-lft-widget").show(300);
  });
});






/**
 * ---------------------------------------
 * This demo was created using amCharts 5.
 * 
 * For more information visit:
 * https://www.amcharts.com/
 * 
 * Documentation is available at:
 * https://www.amcharts.com/docs/v5/
 * ---------------------------------------
 */

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartdiv");


// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);


// Create the map chart
// https://www.amcharts.com/docs/v5/charts/map-chart/
var chart = root.container.children.push(am5map.MapChart.new(root, {
  panX: "rotateX",
  panY: "translateY",
  projection: am5map.geoNaturalEarth1()
}));


// Create main polygon series for countries
// https://www.amcharts.com/docs/v5/charts/map-chart/map-polygon-series/
var polygonSeries = chart.series.push(am5map.MapPolygonSeries.new(root, {
  geoJSON: am5geodata_worldLow,
  exclude: ["AQ"]
}));

polygonSeries.mapPolygons.template.setAll({
  tooltipText: "{name}",
  toggleKey: "active",
  interactive: true
});

polygonSeries.mapPolygons.template.states.create("hover", {
  fill: root.interfaceColors.get("primaryButtonHover")
});

polygonSeries.mapPolygons.template.states.create("active", {
  fill: root.interfaceColors.get("primaryButtonActive")
});

// Set clicking on "water" to zoom out
chart.chartContainer.get("background").events.on("click", function() {
  chart.goHome();
})

// Add zoom control
// https://www.amcharts.com/docs/v5/charts/map-chart/map-pan-zoom/#Zoom_control
var zoomControl = chart.set("zoomControl", am5map.ZoomControl.new(root, {}));
var homeButton = zoomControl.children.moveValue(am5.Button.new(root, {
  paddingTop: 10,
  paddingBottom: 10,
  icon:
    am5.Graphics.new(root, {
      svgPath: "M16,8 L14,8 L14,16 L10,16 L10,10 L6,10 L6,16 L2,16 L2,8 L0,8 L8,0 L16,8 Z M16,8",
      fill: am5.color(000000)
    })
}), 0)

homeButton.events.on("click", function() {
  chart.goHome();
})

// Make stuff animate on load
chart.appear(1000, 100);

</script>

</script>

@endsection
