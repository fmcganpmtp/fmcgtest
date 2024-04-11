@extends('layouts.template')
@section('title', 'Edit Profile')
@section('content')




<section class="my-prof-new">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="prf-out-c11">
          <div class="profile-Container">
            <div class="cover-c">
              <div class="cover-image"><img src="assets/images/cover-image.jpg"> <a href=""  data-bs-toggle="modal" data-bs-target="#exampleModal" class="edit-btn-prf"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a> </div>
              <div class="pro-img-row">
                <div class="row">
                  <div class="col-lg-4 col-12">
                    <div class="prof-imgg"><img src="assets/images/pro-f-image.jpg"> <a href=""  data-bs-toggle="modal" data-bs-target="#exampleModal" class="edit-btn-prf"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a> </div>
                  </div>
                  <div class="col-lg-8 col-12"> <a href="#" class="greenButton btn-save">Save</a> </div>
                </div>
              </div>
            </div>
            <div class="prof-inner-C edit-prf">
              
              
              
              <div class="edit_top" style="display:none;">
              <div class="pro-basic-info">
                <h2>
                <input type="password" class="form-control" id="inputPassword" placeholder="Company Name">
                <h3>
                  <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"> Select Company Type </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                      <li><a class="dropdown-item">
                        <input name="" type="checkbox" value="">
                        wholesaler</a></li>
                      <li><a class="dropdown-item" >
                        <input name="" type="checkbox" value="">
                        Distributor</a></li>
                      <li><a class="dropdown-item" >
                        <input name="" type="checkbox" value="">
                        Private Label / Brand</a></li>
                      <li><a class="dropdown-item">
                        <input name="" type="checkbox" value="">
                        Trader</a></li>
                      <li><a class="dropdown-item" >
                        <input name="" type="checkbox" value="">
                        Retailer</a></li>
                      <li><a class="dropdown-item" >
                        <input name="" type="checkbox" value="">
                        Hospitality</a></li>
                    </ul>
                  </div>
                </h3>
                <h4>
                  <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"> Select Product Categories </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                      <li><a class="dropdown-item">
                        <input name="" type="checkbox" value="">
                        Food</a></li>
                      <li><a class="dropdown-item" >
                        <input name="" type="checkbox" value="">
                        Soft Drinks</a></li>
                      <li><a class="dropdown-item" >
                        <input name="" type="checkbox" value="">
                        Alcohol Drinks</a></li>
                      <li><a class="dropdown-item">
                        <input name="" type="checkbox" value="">
                        Health care</a></li>
                      <li><a class="dropdown-item" >
                        <input name="" type="checkbox" value="">
                        household </a></li>
                      <li><a class="dropdown-item" >
                        <input name="" type="checkbox" value="">
                        beauty and personal care</a></li>
                    </ul>
                  </div>
                </h4>
              </div>
              <div class="pr-adrrs-blk">
                <div class="row">
                  <div class="col-lg-4 col-12">
                    <ul class="bsc-inf">
                      <li class="inf">
                        <input type="password" class="form-control" id="inputPassword" placeholder="Company Email">
                      </li>
                      <li class="tl">
                        <input type="password" class="form-control" id="inputPassword" placeholder="Company Phone">
                      </li>
                      <li class="wb">
                        <input type="password" class="form-control" id="inputPassword" placeholder="Company Website">
                      </li>
                    </ul>
                  </div>
                  <div class="col-lg-4 col-12">
                    <ul class="prf-adr">
                      <li>
                        <input type="password" class="form-control" id="inputPassword" placeholder="Street">
                      </li>
                      <li>
                        <input type="password" class="form-control" id="inputPassword" placeholder="Zipcode, City">
                      </li>
                      <li>
                        <input type="password" class="form-control" id="inputPassword" placeholder="Country">
                      </li>
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
                </div>
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active " id="home" role="tabpanel" aria-labelledby="home-tab"> <a href="#" class="greenButton btn-save">Save</a>
                    <div class="row pr-row">
                      <div class="col-lg-6 col-12">
                        <div class="prf-abt-txt">
                          <div class="mb-3">
                            <textarea class="form-control editabt-area" id="exampleFormControlTextarea1"  placeholder="Enter Company Description"></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6 col-12">
                        <div class="cmpny-prof"><img src="assets/images/company-prof-1.jpg"><a href=""  data-bs-toggle="modal" data-bs-target="#exampleModal" class="edit-btn-prf"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a></div>
                        <div class="cmpny-prof"><a href=""  data-bs-toggle="modal" data-bs-target="#exampleModal" class="edit-btn-prf"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a><img src="assets/images/company-prof-2.jpg"></div>
                      </div>
                    </div>
                  </div>
                  <!-- Modal -->
                  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Edit Image</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <div class="file-drop-area form-group">
                            <label>Change Image</label>
                            <input type="file" class="file-input form-control" accept=".jfif,.jpg,.jpeg,.png,.gif" multiple="">
                          </div>
                          <button type="submit" class="green-button">Upload</button>
                        </div>
                        <div class="modal-footer"> </div>
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
                  <div class="tab-pane fade " id="contact" role="tabpanel" aria-labelledby="contact-tab"> <a href="#" class="greenButton btn-save">Save</a>
                    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
                    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
                    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
                    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
                    <div id="chartdiv"></div>
                    <div class="map-descrip">
					
                      <div class="row">
                        <div class="col-lg-6 col-12">
						
                        <h3><b class="rg-active"></b>Regions we are active in</h3>
						
                        <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
						
                        <h2 class="accordion-header" id="headingOne">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Select active regions</button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                        <div class="map-edit-menu">
                        <ul  class="accordion accordion1">
                          <li>
                            <div class="link">
                              <input name="" type="checkbox" value="">
                              Asia<i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu">
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                            </ul>
                          </li>
                          <li>
                            <div class="link">
                              <input name="" type="checkbox" value="">
                              Europe<i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu">
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                            </ul>
                          </li>
                          <li>
                            <div class="link">
                              <input name="" type="checkbox" value="">
                              Afric<i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu">
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                            </ul>
                          </li>
                          <li>
                            <div class="link">
                              <input name="" type="checkbox" value="">
                              North America<i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu">
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                            </ul>
                          </li>
                          <li>
                            <div class="link">
                              <input name="" type="checkbox" value="">
                              South America<i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu">
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                            </ul>
                          </li>
                          <li>
                            <div class="link">
                              <input name="" type="checkbox" value="">
                              Australia<i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu">
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                            </ul>
                          </li>
                          <li>
                            <div class="link">
                              <input name="" type="checkbox" value="">
                              Antarctica <i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu">
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                            </ul>
                          </li>
                          </div>
                          </div>
                          </div>
                          </div>
                          </div>
                          </div>
						  
                          <div class="col-lg-6 col-12">
                          <h3><b class="exp"></b>Regions we would like to expand to</h3>
						  
						  
						<div class="accordion" id="accordionExample2">
                        <div class="accordion-item">
						
                        <h2 class="accordion-header" id="headingOne2">
                          <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="true" aria-controls="collapseOne"> Select Regions of Interest </button>
                        </h2>
                        <div id="collapseOne2" class="accordion-collapse collapse " aria-labelledby="headingOne2" data-bs-parent="#accordionExample2">
                        <div class="accordion-body">
                        <div class="map-edit-menu">
                        <ul  class="accordion accordion2">
                          <li>
                            <div class="link">
                              <input name="" type="checkbox" value="">
                              Asia<i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu">
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                            </ul>
                          </li>
                          <li>
                            <div class="link">
                              <input name="" type="checkbox" value="">
                              Europe<i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu">
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                            </ul>
                          </li>
                          <li>
                            <div class="link">
                              <input name="" type="checkbox" value="">
                              Afric<i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu">
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                            </ul>
                          </li>
                          <li>
                            <div class="link">
                              <input name="" type="checkbox" value="">
                              North America<i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu">
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                            </ul>
                          </li>
                          <li>
                            <div class="link">
                              <input name="" type="checkbox" value="">
                              South America<i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu">
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                            </ul>
                          </li>
                          <li>
                            <div class="link">
                              <input name="" type="checkbox" value="">
                              Australia<i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu">
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                            </ul>
                          </li>
                          <li>
                            <div class="link">
                              <input name="" type="checkbox" value="">
                              Antarctica <i class="fa fa-chevron-down"></i></div>
                            <ul class="submenu">
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                              <li>
                                <input name="" type="checkbox" value="">
                                Country Name</li>
                            </ul>
                          </li>
                          </div>
                          </div>
                          </div>
                          </div>
                          </div>  
						  
						  
						  
						  
						  
						  
						  
						  
						  
						  
						  
						  
						  
						  
						  
                          
                      
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade " id="contact1" role="tabpanel" aria-labelledby="contact-tab1"> <a href="#" class="greenButton btn-save">Save</a>
                  <div class="row">
                    <div class="col-lg-4 col-12">
                      <div class="prf-inner add-user-sect">
                        <div class="tab-prf-image add-us-img"><img src="assets/images/add-user.png"></div>
                        <a href="#" class="invite-us-btn" data-bs-toggle="modal" data-bs-target="#exampleModal2">Invite User</a> </div>
                    </div>
                    <div class="col-lg-4 col-12">
                      <div class="prf-inner">
                        <div class="tab-prf-image"><img src="assets/images/chat-02.jpg"> <a class="edit-btn-prf"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a></div>
                        <div class="edit-prf-btnc">
                          <button>Send password reset</button>
                          <button>Remove User</button>
                        </div>
                        <ul class="bsc-inf">
                          <li class="us-nam"><a href="#">Giovanni Lalaiui</a></li>
                          <li class="des"><a href="#">senior sales representative</a></li>
                          <li class="inf"><a href="mailt:info@ujifoods.com">info@ujifoods.com</a></li>
                          <li class="tl"><a href="tel:+919888211125">+919888211125</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Invite User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <ul class="bsc-inf prf-edit-form">
                          <li class="us-nam">
                            <div class="row">
                              <div class="col-lg-6 col-12">
                                <input type="password" class="form-control" id="inputPassword" placeholder="First Name">
                              </div>
                              <div class="col-lg-6 col-12">
                                <input type="password" class="form-control" id="inputPassword" placeholder="Last Name">
                              </div>
                            </div>
                          </li>
                          <li class="des"><a href="#"><input type="password" class="form-control" id="inputPassword" placeholder="Role" <="" a=""></a></li>
                          <a href="#"> </a>
                          <li class="inf"><a href="#"></a><a href="mailt:info@ujifoods.com"><input type="password" class="form-control" id="inputPassword" placeholder="Email" <="" a=""></a></li>
                          <a href="mailt:info@ujifoods.com"> </a>
                          <li class="tl"><a href="mailt:info@ujifoods.com"></a><a href="tel:+919888211125"><input type="password" class="form-control" id="inputPassword" placeholder="Phone" <="" a=""></a></li>
                          <a href="tel:+919888211125"> </a>
                        </ul>
                        <button type="submit" class="green-button btn-save">Send Invite</button>
                      </div>
                      <div class="modal-footer"> </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade " id="contact2" role="tabpanel" aria-labelledby="contact-tab2"> <a href="#" class="greenButton btn-save">Save</a>
                  <div class="pr-tab-inner">
                    <div class="row">
                      <div class="col-lg-3 col-12">
                        <div class="tab-profile-user-img"><img src="assets/images/juan.jpg"></div>
                      </div>
                      <div class="col-lg-9 col-12">
                        <ul class="bsc-inf prf-edit-form">
                          <li class="us-nam">
                            <div class="row">
                              <div class="col-lg-6 col-12">
                                <input type="password" class="form-control" id="inputPassword" placeholder="First Name">
                              </div>
                              <div class="col-lg-6 col-12">
                                <input type="password" class="form-control" id="inputPassword" placeholder="Last Name">
                              </div>
                            </div>
                          </li>
                          <li class="des"><input type="password" class="form-control" id="inputPassword" placeholder="Role1111"></li>
                          <li class="inf"><input type="password" class="form-control" id="inputPassword" placeholder="sssssc"></li>
                          <li class="tl"><input type="password" class="form-control" id="inputPassword" placeholder="Phone"></li>
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


<script>
$fmcg(function() {
	var Accordion = function(el, multiple) {
		this.el = el || {};
		this.multiple = multiple || false;

		// Variables privadas
		var links = this.el.find('.link');
		// Evento
		links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
	}

	Accordion.prototype.dropdown = function(e) {
		var $el = e.data.el;
			$this = $fmcg(this),
			$next = $this.next();

		$next.slideToggle();
		$this.parent().toggleClass('open');

		if (!e.data.multiple) {
			$el.find('.submenu').not($next).slideUp().parent().removeClass('open');
		};
	}	

	var accordion = new Accordion($fmcg('.accordion1'), false);
});
</script>


<script>
$fmcg(function() {
	var Accordion = function(el, multiple) {
		this.el = el || {};
		this.multiple = multiple || false;

		// Variables privadas
		var links = this.el.find('.link');
		// Evento
		links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
	}

	Accordion.prototype.dropdown = function(e) {
		var $el = e.data.el;
			$this = $fmcg(this),
			$next = $this.next();

		$next.slideToggle();
		$this.parent().toggleClass('open');

		if (!e.data.multiple) {
			$el.find('.submenu').not($next).slideUp().parent().removeClass('open');
		};
	}	

	var accordion = new Accordion($fmcg('.accordion2'), false);
});
</script>


@endsection
