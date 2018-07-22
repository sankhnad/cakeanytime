<!doctype html>
<html class="no-js" lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="author" content="M_Adnan" />
<!-- Document Title -->
<title>Shopping Cart | Cake Any Time</title>

<!-- Include SmartWizard CSS -->
<link href="assets/checkout/css/smart_wizard.css" rel="stylesheet" type="text/css" />
<!-- Optional SmartWizard theme -->
<link href="assets/checkout/css/smart_wizard_theme_arrows.css" rel="stylesheet" type="text/css" />

<?php include("include/style.php"); ?>

</head>
<body>

<!-- Start: Page Wrapper -->
<div id="wrap"> 
  
  <?php include("include/header.php"); ?>

    <!-- Content -->
    <div id="content"> 
    
        <section class="checkout-proccess" style="padding: 35px 0;">
            <div class="container">
                <div class="row">
                    <!-- SmartWizard html -->
                    <div id="smartwizard">
                        <ul>
                            <li><a href="#step-1"><small>Step 1</small><br />Shopping Cart</a></li>
                            <li><a href="#step-2"><small>Step 2</small><br />Delivery Methods</a></li>
                            <li><a href="#step-3"><small>Step 3</small><br />Payment Methods</a></li>
                            <li><a href="#step-4"><small>Step 4</small><br />Confirmation</a></li>
                        </ul>
                        
                        <div>
                            <div id="step-1" class="">

                                <section class="shopping-cart padding-bottom-60">

                                    <table class="table">
                                      <thead>
                                        <tr>
                                          <th>Items</th>
                                          <th class="text-center">Price</th>
                                          <th class="text-center">Quantity</th>
                                          <th class="text-center">Total Price </th>
                                          <th>&nbsp; </th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        
                                        <!-- Item Cart -->
                                        <tr>
                                          <td><div class="media">
                                              <div class="media-left"> <a href="#."> <img class="img-responsive" src="assets/images/item-img-1-1.jpg" alt=""> </a> </div>
                                              <div class="media-body">
                                                <p>E-book Reader Lector De Libros
                                                  Digitales 7''</p>
                                              </div>
                                            </div></td>
                                          <td class="text-center">$200.00</td>
                                          <td class="text-center"><!-- Quinty -->
                                            
                                            <div class="quinty">
                                              <input type="number" value="02">
                                            </div></td>
                                          <td class="text-center">$400.00</td>
                                          <td class="text-center"><a href="#." class="remove"><i class="fa fa-close"></i></a></td>
                                        </tr>
                                        
                                        <!-- Item Cart -->
                                        <tr>
                                          <td><div class="media">
                                              <div class="media-left"> <a href="#."> <img class="img-responsive" src="assets/images/item-img-1-2.jpg" alt=""> </a> </div>
                                              <div class="media-body">
                                                <p>E-book Reader Lector De Libros
                                                  Digitales 7''</p>
                                              </div>
                                            </div></td>
                                          <td class="text-center"><i class="fa fa-inr" aria-hidden="true"></i> 200.00</td>
                                          <td class="text-center"><div class="quinty padding-top-20">
                                              <input type="number" value="02">
                                            </div></td>
                                          <td class="text-center"><i class="fa fa-inr" aria-hidden="true"></i> 400.00</td>
                                          <td class="text-center"><a href="#." class="remove"><i class="fa fa-close"></i></a></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    
                                    <!-- Promotion -->
                                    <div class="promo">
                                      <div class="coupen">
                                        <label> Promotion Code
                                          <input type="text" placeholder="Your code here">
                                          <button type="submit"><i class="fa fa-arrow-circle-right"></i></button>
                                        </label>
                                      </div>
                                      
                                      <!-- Grand total -->
                                      <div class="g-totel">
                                        <h5>Grand total: <span>$500.00</span></h5>
                                      </div>
                                    </div>

                                </section>
                            </div>

                            <div id="step-2" class="">
                                <div class="pay-method">
                                    <div class="row">

                                        <div class="col-md-8"> 
                                        
                                            <!-- Your information -->
                                            <div class="heading">
                                              <h2>Your information</h2>
                                              <hr>
                                            </div>

                                            <form>
                                            <div class="row"> 
                                                
                                                <!-- Name -->
                                                <div class="col-sm-6">
                                                  <label> First name
                                                    <input class="form-control" type="text">
                                                  </label>
                                                </div>
                                                
                                                <!-- Number -->
                                                <div class="col-sm-6">
                                                  <label> Last Name
                                                    <input class="form-control" type="text">
                                                  </label>
                                                </div>                                                
                                                
                                                <div class="col-xs-4">
                                                    <label> Country 
                                                    <select name="" id="weight-sel" class="form-control">
                                                        <option value="14">Select Country *</option>
                                                        <option> USA</option>
                                                        <option> USA</option>
                                                        <option> USA</option>
                                                        <option> USA</option>
                                                        <option> USA</option>
                                                        <option> USA</option>
                                                    </select></label>
                                                </div>

                                                <div class="col-xs-4">
                                                  <label> City 
                                                  <select name="" id="weight-sel" class="form-control">
                                                        <option value="14">Select City *</option>
                                                        <option> USA</option>
                                                        <option> USA</option>
                                                        <option> USA</option>
                                                        <option> USA</option>
                                                        <option> USA</option>
                                                        <option> USA</option>
                                                    </select></label>
                                                </div>

                                                <div class="col-sm-4">
                                                  <label> State
                                                    <input class="form-control" type="text">
                                                  </label>
                                                </div>

                                                <!-- Zip code -->
                                                <div class="col-sm-4">
                                                  <label> Zip code
                                                    <input class="form-control" type="text">
                                                  </label>
                                                </div>
                                                
                                                <!-- Address -->
                                                <div class="col-sm-8">
                                                  <label> Address
                                                    <input class="form-control" type="text">
                                                  </label>
                                                </div>
                                                
                                                <!-- Phone -->
                                                <div class="col-sm-6">
                                                  <label> Phone
                                                    <input class="form-control" type="text">
                                                  </label>
                                                </div>
                                                
                                                <!-- Number -->
                                                <div class="col-sm-6">
                                                  <label> Email
                                                    <input class="form-control" type="email">
                                                  </label>
                                                </div>

                                              </div>
                                            </form>
                                        </div>
                                      
                                        <!-- Select Your Transportation -->
                                        <div class="col-md-4">
                                            <div class="heading">
                                              <h2>Select Your Transportation</h2>
                                              <hr>
                                            </div>
                                            <div class="transportation">
                                              <div class="row"> 
                                                
                                                <!-- Free Delivery -->
                                                <div class="col-sm-12">
                                                  <div class="charges">
                                                    <h6>Free Delivery</h6>
                                                    <br>
                                                    <span>7 - 12 days</span> </div>
                                                </div>
                                                
                                                <!-- Free Delivery -->
                                                <div class="col-sm-12">
                                                  <div class="charges select">
                                                    <h6>Fast Delivery</h6>
                                                    <br>
                                                    <span>4 - 7 days</span> <span class="deli-charges"> +<i class="fa fa-inr" aria-hidden="true"></i> 25 </span> </div>
                                                </div>
                                                <!-- Expert Delivery -->
                                                <div class="col-sm-12">
                                                  <div class="charges">
                                                    <h6>Expert Delivery</h6>
                                                    <br>
                                                    <span>24 - 48 Hours</span> <span class="deli-charges"> +<i class="fa fa-inr" aria-hidden="true"></i> 75 </span> </div>
                                                </div>
                                              </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div id="step-3" class="">
                                <div class="pay-method">
                                    <div class="row">
                                      <div class="col-md-6"> 
                                        
                                        <!-- Your Card -->
                                        <div class="heading">
                                          <h2>Your Card</h2>
                                          <hr>
                                        </div>
                                        <img src="images/card-icon.png" alt=""> </div>
                                      <div class="col-md-6"> 
                                        
                                        <!-- Your information -->
                                        <div class="heading">
                                          <h2>Your information</h2>
                                          <hr>
                                        </div>
                                        <form>
                                          <div class="row"> 
                                            
                                            <!-- Cardholder Name -->
                                            <div class="col-sm-6">
                                              <label> Cardholder Name
                                                <input class="form-control" type="text">
                                              </label>
                                            </div>
                                            
                                            <!-- Card Number -->
                                            <div class="col-sm-6">
                                              <label> Card Number
                                                <input class="form-control" type="text">
                                              </label>
                                            </div>
                                            
                                            <!-- Card Number -->
                                            <div class="col-sm-7">
                                              <label> Expire Date 
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <select name="" id="weight-sel" class="form-control">
                                                            <option> MM</option>
                                                            <option> 01</option>
                                                            <option> 02</option>
                                                            <option> 03</option>
                                                            <option> 04</option>
                                                            <option> 05</option>
                                                            <option> 06</option>
                                                            <option> 07</option>
                                                            <option> 08</option>
                                                            <option> 09</option>
                                                            <option> 10</option>
                                                            <option> 11</option>
                                                            <option> 12</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-xs-6">
                                                        <select name="" id="weight-sel" class="form-control">
                                                            <option> YYYY</option>
                                                            <option> 2001</option>
                                                            <option> 2002</option>
                                                            <option> 2003</option>
                                                            <option> 2004</option>
                                                            <option> 2005</option>
                                                            <option> 2006</option>
                                                            <option> 2007</option>
                                                            <option> 2008</option>
                                                            <option> 2009</option>
                                                            <option> 2010</option>
                                                            <option> 2011</option>
                                                            <option> 2012</option>
                                                        </select>
                                                    </div>

                                                </div></label>
                                            </div>
                                            <div class="col-sm-5">
                                              <label> CVV
                                                <input class="form-control" type="text">
                                              </label>
                                            </div>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                </div>
                            </div>

                            <div id="step-4" class="">
                                
                                <div class="pay-method check-out"> 
              
                                      <!-- Shopping Cart -->
                                    <div class="heading">
                                        <h2>Shopping Cart</h2>
                                        <hr>
                                    </div>
                                      
                                      <!-- Check Item List -->
                                    <ul class="row check-item">
                                        <li class="col-xs-6">
                                          <p>E-book Reader Lector De Libros Digitales 7''</p>
                                        </li>
                                        <li class="col-xs-2 text-center">
                                          <p><i class="fa fa-inr" aria-hidden="true"></i> 200.00</p>
                                        </li>
                                        <li class="col-xs-2 text-center">
                                          <p>02 Items</p>
                                        </li>
                                        <li class="col-xs-2 text-center">
                                          <p><i class="fa fa-inr" aria-hidden="true"></i> 400.00</p>
                                        </li>
                                    </ul>
                                      
                                    <!-- Check Item List -->
                                    <ul class="row check-item">
                                        <li class="col-xs-6">
                                          <p>Portero Visor Timbre Camara Ip Wifi lunax 2.7</p>
                                        </li>
                                        <li class="col-xs-2 text-center">
                                          <p><i class="fa fa-inr" aria-hidden="true"></i> 100.00</p>
                                        </li>
                                        <li class="col-xs-2 text-center">
                                          <p>01 Items</p>
                                        </li>
                                        <li class="col-xs-2 text-center">
                                          <p><i class="fa fa-inr" aria-hidden="true"></i> 100.00</p>
                                        </li>
                                    </ul>
                                      
                                    <!-- Payment information -->
                                    <div class="heading margin-top-50">
                                        <h2>Payment information</h2>
                                        <hr>
                                    </div>
                                      
                                    <!-- Check Item List -->
                                    <ul class="row check-item">
                                        <li class="col-xs-6">
                                          <p><img class="margin-right-20" src="images/visa-card.jpg" alt=""> Visa Credit Card</p>
                                        </li>
                                        <li class="col-xs-6 text-center">
                                          <p>Card number:   XXX-XXX-XXX-6886</p>
                                        </li>
                                    </ul>
                                      
                                    <!-- Delivery infomation -->
                                    <div class="heading margin-top-50">
                                        <h2>Delivery infomation</h2>
                                        <hr>
                                    </div>
                                      
                                    <!-- Information -->
                                    <ul class="row check-item infoma">
                                        <li class="col-sm-3">
                                          <h6>Name</h6>
                                          <span>Alex Adkins</span> </li>
                                        <li class="col-sm-3">
                                          <h6>Phone</h6>
                                          <span>(+100) 987 654 3210</span> </li>
                                        <li class="col-sm-3">
                                          <h6>Country</h6>
                                          <span>USA</span> </li>
                                        <li class="col-sm-3">
                                          <h6>Email</h6>
                                          <span>Alexadkins@gmail.com</span> </li>
                                        <li class="col-sm-3">
                                          <h6>City</h6>
                                          <span>NewYork</span> </li>
                                        <li class="col-sm-3">
                                          <h6>State</h6>
                                          <span>NewYork</span> </li>
                                        <li class="col-sm-3">
                                          <h6>Zipcode</h6>
                                          <span>01234</span> </li>
                                        <li class="col-sm-3">
                                          <h6>Address</h6>
                                          <span>569 Lexington Ave, New York, NY</span> </li>
                                    </ul>
                                      
                                    <!-- Information -->
                                    <ul class="row check-item infoma exp">
                                        <li class="col-sm-6"> <span>Expert Delivery</span> </li>
                                        <li class="col-sm-3">
                                          <h6>24 - 48 hours</h6>
                                        </li>
                                        <li class="col-sm-3">
                                          <h5>+25</h5>
                                        </li>
                                    </ul>
                                      
                                    <!-- Totel Price -->
                                    <div class="totel-price">
                                        <h4><small> Total Price: </small> <i class="fa fa-inr" aria-hidden="true"></i> 525.00</h4>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    <?php include("include/footer.php"); ?>

</div>
<!-- End: Page Wrapper --> 

<?php include("include/script.php"); ?>

<!-- Include jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<!-- Include SmartWizard JavaScript source -->
<script type="text/javascript" src="assets/checkout/js/jquery.smartWizard.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        
        // Step show event 
        $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
           //alert("You are on step "+stepNumber+" now");
           if(stepPosition === 'first'){
               $("#prev-btn").addClass('disabled');
           }else if(stepPosition === 'final'){
               $("#next-btn").addClass('disabled');
           }else{
               $("#prev-btn").removeClass('disabled');
               $("#next-btn").removeClass('disabled');
           }
        });
        
// Toolbar extra buttons
var btnFinish = $('<button></button>').text('Finish').addClass('btn btn-info').on('click', function(){ alert('Finish Clicked'); });
var btnCancel = $('<button></button>').text('Cancel').addClass('btn btn-danger').on('click', function(){ $('#smartwizard').smartWizard("reset"); });                         
        
        
        // Smart Wizard
        $('#smartwizard').smartWizard({ 
                selected: 0, 
                theme: 'default',
                transitionEffect:'fade',
                showStepURLhash: true,
                toolbarSettings: {toolbarPosition: 'both',
                                  toolbarExtraButtons: [btnFinish, btnCancel]
                                }
        });
                                     
        
        
        
        $("#prev-btn").on("click", function() {
            // Navigate previous
            $('#smartwizard').smartWizard("prev");
            return true;
        });
        
        $("#next-btn").on("click", function() {
            // Navigate next
            $('#smartwizard').smartWizard("next");
            return true;
        });
        
        $("#theme_selector").on("change", function() {
            // Change theme
            $('#smartwizard').smartWizard("theme", $(this).val());
            return true;
        });
        
        // Set selected theme on page refresh
        $("#theme_selector").change();
    });   
</script>  

</body>
</html>