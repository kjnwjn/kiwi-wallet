<?php
require_once('./vendor/autoload.php');
require_once('./private/middlewares/Api.middleware.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
?>
<header class="position-fixed fixed-top">
		<nav class="navbar navbar-expand-lg navbar-dark" style="background-image: linear-gradient(to right, #005892, #ea124f)">
			<div class="container">
				<a class="navbar-brand d-flex align-items-center" 
				href='<?= getenv('BASE_URL') ?>'>
					<i class='fas  mr-2' style='font-size:30px'></i>
					HOME
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse"
					data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
					aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
	
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link text-light mr-4" href="<?= getenv('BASE_URL') ?>transfer">
                                TRANSFER
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light mr-4" href="<?= getenv('BASE_URL') ?>recharge">
                                RECHARGE
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light mr-4" href="<?= getenv('BASE_URL') ?>withdraw">
                                WITHDRAW
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light mr-4" href="<?= getenv('BASE_URL') ?>buyPhoneCard">
                                BUY PHONE CARD
                            </a>
                        </li>
        
                        <li class="nav-item">
                            <a class="nav-link text-light mr-4" href="<?= getenv('BASE_URL') ?>transactionHistory">
                                TRANSACTIONS HISTORY
                            </a>
                        </li>
                        <li class="nav-item dropdown ">
                            
                        <?php
                       
                        if(isset($_COOKIE['JWT_TOKEN'])){
                            echo '
                                    <a class="nav-link dropdown-toggle text-light mr-4"
                                    href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        USER
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                                    echo("<a href='". getenv('BASE_URL') ."profile' class='dropdown-item'>Profile</a>");

                                    echo("<a href='". getenv('BASE_URL') ."changepassword' class='dropdown-item'>Change Password</a>");

                                    echo("<a href='". getenv('BASE_URL') ."logout' class='dropdown-item'>logout</a>");
                                } else{
                                   echo("<button type='button' class='btn btn-light'><a href='". getenv('BASE_URL') ."login' style='text-decoration:none;color:black'>Login</a></button>");
                                   echo("<button type='button' class='btn btn-success'><a href='". getenv('BASE_URL') ."register' style='text-decoration:none;color:white;'>Register</a></button>");
                                }
                            ?>
                        </div>
                    </li>   
                  
					</ul>
				</div>
			</div>
		</nav>
	</header>