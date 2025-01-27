<?php
include("includes/connection.php");

$get_cars = "SELECT * FROM cars";
$cars_result = mysqli_query($con, $get_cars);
?>
<!DOCTYPE html>
<?php
session_start();
include("includes/header.php");

if(!isset($_SESSION['email'])){
	header("location: accounts.php");
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car rental</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">


</head>
<body>
    <header>
        <a href="#home" class="logo"> <img src="img/logo.png" alt=""></a>

        <div class="bx bx-menu" id="menu-icon"></div>

        <ul class="navbar">
            <li><a href="#home">Home</a></li>
            <li><a href="#guide">Guide</a></li>
            <li><a href="#cars">Cars</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#reviews">Reviews</a></li>
        </ul>
        <div class="header-btn">
           <a href="profile.php">
           <?php echo "
            <p><img src='users/$user_image' class='img-circle' width='50px' height='50px'></p>
            " ?>
           </a>
        </div>

    </header>
    <!--home-->
    <section class="home" id="home">
        <div class="text">
            <h1><span>Looking</span> to<br> rent a car</h1>
            <p>for your upcoming trip, business travel, or any other occasion, you've come to the right place. Our user-friendly platform makes it easy to find the perfect vehicle to meet your needs and budget.</p>
            <div class="app-stores">
                <img src="img/android.png" alt="playstore">
                <img src="img/ios.png" alt="applestore">
            </div>
        </div>

    </section>
    <!--guide-->
    <section class="guide" id="guide">
        <div class="heading">
            <span>how it works</span>
            <h1>rent with 3 easy steps</h1>
        </div>
        <div class="guide-container">
            <div class="box">
                <i class='bx bxs-car'></i>
                <h2>choose a car</h2>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Veritatis nulla saepe rem placeat voluptate ipsam quam nisi omnis fuga cum ratione aliquid, facere aliquam ipsum ullam distinctio perferendis. Ad, voluptatum!</p>

            </div>

            <div class="box">
                <i class='bx bxs-calendar-check'></i>
                <h2>set pick-up date and location</h2>
                <p>Select the city, airport, or neighborhood where you'd like to pick up your rental car. Our vast network of conveniently located branches makes it easy to find a pick-up spot that's close to your starting point.</p>

            </div>

            <div class="box">
                <i class='bx bxs-calendar-star'></i>
                <h2>set return date and location</h2>
                <p>Decide where you'd like to return the car when your rental is complete. This can be the same location as your pick-up, or a different destination if you need a one-way rental</p>

            </div>

        </div>

    </section>

    <!--cars-->
    <section class="cars" id="cars">
        <div class="heading">
            <span>Some of the cars you can find here</span>
            <h1>Explore our best deals <br> with our top dealers</h1>
        </div>
        <div class="cars-container">
            <?php while ($car = mysqli_fetch_assoc($cars_result)): ?>
                <div class="box">
                    <div class="box-img">
                        <img src="img/<?php echo htmlspecialchars($car['car_image']); ?>" alt="<?php echo htmlspecialchars($car['car_name']); ?>">
                    </div>
                    <p><?php echo htmlspecialchars($car['car_year']); ?></p>
                    <h3><?php echo htmlspecialchars($car['car_name']); ?></h3>
                    <h2>$<?php echo htmlspecialchars(number_format($car['price_per_day'], 2)); ?> <span>/day</span></h2>
                    <button class="btn rent-btn" 
                            data-id="<?php echo $car['id']; ?>" 
                            <?php echo $car['rental_status'] !== 'available' ? 'disabled' : ''; ?>>
                        <?php
                            echo $car['rental_status'] === 'available' ? 'Rent Now' :
                                ($car['rental_status'] === 'in_progress' ? 'In Progress' : 'Rented');
                        ?>
                    </button>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!--about-->
    <section class="about" id="about">
        <div class="heading">
            <span>about us</span>
            <h1>best customer expreince</h1>

        </div>
        <div class="about-container">
            <div class="about-img">
                <img src="img/about.jpg" alt="">
            </div>
            <div class="about-text">
                <span>about us</span>
                <p>At emabrck mobility we're dedicated to providing our customers with a premium car rental experience that exceeds their expectations. As a leading provider of rental vehicles, we've built our reputation on unparalleled service, a diverse fleet of well-maintained cars, and a steadfast commitment to customer satisfaction</p>
                <p>All of our cars are meticulously maintained to the highest standards, ensuring they are safe, reliable, and ready to hit the road. We regularly update our fleet with the latest models from top manufacturers, so you can always expect a premium, modern driving experience</p>
                <a href="#" class="btn">Learn more</a>
            </div>


        </div>
    </section>
    <!--review-->
    <section class="reviews" id="reviews">
        <div class="heading">
            <span>Reviews</span>
            <h1>what our customers say</h1>

        </div>
        <div class="reviews-container">
            <div class="box">
                <div class="rev-img">
                    <img src="img/images (1).jpeg" alt="">
                </div>
                <h2>Nahom desalegh</h2>
                <div class="stars">
                    
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star-half'></i>
                </div>
                <p>I can't say enough good things about my experience, I rented a mid-size toyota yaris sidan for a week-long family road trip, and everything was absolutely perfect. The pickup and drop-off process was quick and effortless, the vehicle was spotless and ran like a dream, and the customer service was top-notch. Any time I had a question, the team was incredibly responsive and helpful. I'll definitely be using [Website Name] for all my future car rental needs. Highly recommended</p>
                

            </div>

            <div class="box">
                <div class="rev-img">
                    <img src="img/images (2).jpeg" alt="">
                </div>
                <h2>mariyamawit abera</h2>
                <div class="stars">
                    
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star-half'></i>
                </div>
                <p>Renting from you guys  was a breeze! I needed a car for a business trip to a city I wasn't familiar with, and the website made it super easy to find and book the right vehicle. The Civic I ended up with was clean, comfortable, and perfect for navigating the busy city streets. The only slight hiccup was a slight delay in the pickup process, but the staff was apologetic and gave me a discounted rate as compensation. Overall, a really great experience and I wouldn't hesitate to rent again.</p>

            </div>

            <div class="box">
                <div class="rev-img">
                    <img src="img/image(3).jpeg" alt="">
                </div>
                <h2>tommy boy</h2>
                <div class="stars">
                    
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star'></i>
                    <i class='bx bxs-star-half'></i>
                </div>
                <p>I had a pretty good experience renting from this site, but there were a couple of minor issues that kept me from giving 5 stars. The online booking process was seamless, and the car itself (suzuki desire) was in great shape. However, when I went to pick it up, they didn't have the exact model I had reserved and tried to give me a different sedan instead. After some back-and-forth, they were able to accommodate my request, but it was a bit of an inconvenience. Additionally, the return process was a bit chaotic, with a long line and not enough staff. That said, the rental rates were competitive and the customer service was generally friendly and helpful. I'd use them again, but with the expectation of a few minor hiccups</p>

            </div>
        </div>
        

    </section>
    <div class="copyright">
        <p>&#169;copyright All Right Reserved</p>
        <div class="social">
            <a href="#"><i class="bx bxl-facebook"></i></a>
            <a href="#"><i class="bx bxl-twitter"></i></a>
            <a href="#"><i class="bx bxl-instagram"></i></a>
            <a href="#"><i class="bx bxl-tiktok"></i></a>
        </div>

    </div>

<script src="https://unpkg.com/scrollreveal"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(".rent-btn").click(function() {
            const button = $(this);
            const carId = button.data("id");
            button.text("In Progress").attr("disabled", true);

            $.post("update_status.php", { id: carId, status: "in_progress" }, function(response) {
                if (response !== "success") {
                    alert("Failed to update status. Please try again.");
                    button.text("Rent Now").attr("disabled", false);
                }
            });
        });
    });
</script>


    <script src="main.js"></script>
    
</body>
</html>