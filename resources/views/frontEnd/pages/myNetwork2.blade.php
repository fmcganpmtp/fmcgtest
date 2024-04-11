@extends('layouts.template')
@section('title', 'Seller Profile')
@section('content')





<sectiion class="my-n-w-new">
  <!-- Modal -->
  <div class="container myNetWork">
    <div class="row">
      <div class="col-lg-12">
        <div class="pr-bottom">
          <div class="card">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Company Database</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">My Network</button>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="top-form-row">
                  <div class="row">
                    <div class="col-lg-3 col-12">
                      <div class="mb-3">
                        <div class="form-group">
                          <select name="" class="form-control">
                            <option> Industry</option>
                            <option>A1</option>
                            <option>A2</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-12">
                      <div class="mb-3">
                        <div class="form-group">
                          <select name="" class="form-control">
                            <option>company type</option>
                            <option>A</option>
                            <option>B</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-12">
                      <div class="form-group">
                        <select name="" class="form-control">
                          <option>Countery</option>
                          <option>India</option>
                          <option>Uk</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3 col-12">
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Name / Keyword">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <?php for($i=1;$i<=8;$i++)
{ ?>
                  <div class="col-lg-4 col-12">
                    <div class="nt-wrk-gray-bx">
                      <div class="row">
                        <div class="col-lg-4 col-12">
                          <div class="nt-wrk-gr-img"><img src="assets/images/nt-wrk-gray-img.jpg"></div>
                        </div>
                        <div class="col-lg-8 col-12">
                          <h2>Beinco</h2>
                          <h3>Producer</h3>
                          <h4>Frasnce</h4>
                          <h5>Alcohol, Perfumes & Fragrances, Household Food Soft Drinks, Confectionary, Health Care, Baby Care</h5>
                        </div>
                      </div>
                      <div class="nw-fray-decrip">
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and </p>
                      </div>
                      <div class="bottm-img-listing">
                        <ul>
                          <li>
                            <div class="gr-img-bx"><img src="assets/images/1680722280_1470736183_PACO-RABANA-1-MILION.png"></div>
                          </li>
                          <li>
                            <div class="gr-img-bx"><img src="assets/images/1686334763_Coca-Cola  355ml (1).jpg"></div>
                          </li>
                          <li>
                            <div class="gr-img-bx"><img src="assets/images/1202312210937081703194628_77183.jpg"></div>
                          </li>
                          <li>
                            <div class="gr-img-bx"><img src="assets/images/1202312210937041703194624_92223.jpg"></div>
                          </li>
                        </ul>
                      </div>
                      <a href="#" class="blue-button">Message</a> </div>
                  </div>
                  <?php } ?>
                </div>
              </div>
              <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
			  
			  
			  
			  
			  
			   <div class="top-form-row">
                  <div class="row">
                    <div class="col-lg-3 col-12">
                      <div class="mb-3">
                        <div class="form-group">
                          <select name="" class="form-control">
                            <option> Industry</option>
                            <option>A1</option>
                            <option>A2</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-12">
                      <div class="mb-3">
                        <div class="form-group">
                          <select name="" class="form-control">
                            <option>company type</option>
                            <option>A</option>
                            <option>B</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-12">
                      <div class="form-group">
                        <select name="" class="form-control">
                          <option>Countery</option>
                          <option>India</option>
                          <option>Uk</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-3 col-12">
                      <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Name / Keyword">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
				
				<div class="col-lg-4 col-12 ">
                    <div class="nt-wrk-gray-bx">
                      <div class="row">
                        <div class="col-lg-4 col-12">
                          <div class="nt-wrk-gr-img"><img src="assets/images/nt-wrk-gray-img.jpg"></div>
                        </div>
                        <div class="col-lg-8 col-12">
                          <h2>Beinco</h2>
                          <h3>Producer</h3>
                          <h4>Frasnce</h4>
                          <h5>Alcohol, Perfumes & Fragrances, Household Food Soft Drinks, Confectionary, Health Care, Baby Care</h5>
                        </div>
                      </div>
                      <div class="nw-fray-decrip">
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and </p>
                      </div>
                      <div class="bottm-img-listing">
                        <ul>
                          <li>
                            <div class="gr-img-bx"><img src="assets/images/1680722280_1470736183_PACO-RABANA-1-MILION.png"></div>
                          </li>
                          <li>
                            <div class="gr-img-bx"><img src="assets/images/1686334763_Coca-Cola  355ml (1).jpg"></div>
                          </li>
                          <li>
                            <div class="gr-img-bx"><img src="assets/images/1202312210937081703194628_77183.jpg"></div>
                          </li>
                          <li>
                            <div class="gr-img-bx"><img src="assets/images/1202312210937041703194624_92223.jpg"></div>
                          </li>
                        </ul>
                      </div>
                      <a href="#" class="green-button">Add to Network</a> </div>
					  
					  <div class="filter-layer"></div>
                  </div>
				
                  <?php for($i=1;$i<=8;$i++)
{ ?>
                  <div class="col-lg-4 col-12 filter-blur">
                    <div class="nt-wrk-gray-bx">
                      <div class="row">
                        <div class="col-lg-4 col-12">
                          <div class="nt-wrk-gr-img"><img src="assets/images/nt-wrk-gray-img.jpg"></div>
                        </div>
                        <div class="col-lg-8 col-12">
                          <h2>Beinco</h2>
                          <h3>Producer</h3>
                          <h4>Frasnce</h4>
                          <h5>Alcohol, Perfumes & Fragrances, Household Food Soft Drinks, Confectionary, Health Care, Baby Care</h5>
                        </div>
                      </div>
                      <div class="nw-fray-decrip">
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and </p>
                      </div>
                      <div class="bottm-img-listing">
                        <ul>
                          <li>
                            <div class="gr-img-bx"><img src="assets/images/1680722280_1470736183_PACO-RABANA-1-MILION.png"></div>
                          </li>
                          <li>
                            <div class="gr-img-bx"><img src="assets/images/1686334763_Coca-Cola  355ml (1).jpg"></div>
                          </li>
                          <li>
                            <div class="gr-img-bx"><img src="assets/images/1202312210937081703194628_77183.jpg"></div>
                          </li>
                          <li>
                            <div class="gr-img-bx"><img src="assets/images/1202312210937041703194624_92223.jpg"></div>
                          </li>
                        </ul>
                      </div>
                      <a href="#" class="green-button">Add to Network</a> </div>
					  
					  <div class="filter-layer"></div>
                  </div>
                  <?php } ?>
                </div>
			  
			  
			  
			  
			  
			  </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</sectiion>






@endsection
@section('footer_script')


@endsection