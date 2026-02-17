<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health & Wellness</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
      crossorigin="anonymous"
    />
    <script
      src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
      integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
      integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
      integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
      crossorigin="anonymous"
    ></script>
    
    <link rel="stylesheet" href="guest.css">
    
</head>
<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <a class="navbar-brand" href="#"><img class="guest-nav-image" src="Images/green_heart_with_leaf.jpg"/><span class="guest-navbar-heading pt-5">Health & Wellness</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ml-auto">
            <a class="nav-link active mr-3" id="gnavitem1" href="#">Home <span class="sr-only">(current)</span></a>
            <a class="nav-link mr-3" id="gnavitem2" href="#">About Us</a>
            <a class="nav-link mr-3" id="gnavitem3" href="#">Plans</a>
            <a class="nav-link mr-3" id="gnavitem4" href="#">Gallery</a>
            <a class="nav-link mr-3" id="gnavitem5" href="#">Contact Us</a>
            <a class="nav-link bg-success mr-3" id="gnavitem6" href="#">Login</a>
            </div>
        </div>
        </nav>
    </div>

    <div class="guest-banner-container align-items-center">
        <div class="guest-banner-content">
            <h1 class="guest-banner-heading">Stay Fit, Stay Healthy!</h1>
            <p class="guest-banner-paragraph">Enjoy fitness, meal plans, and Wellness Boosts</p>
            <button class="get-started-button shadow-lg">Get Started</button>
        </div>

    </div>

    <!-- Guest bottom Cards -->
    
        
    <div class="guest-bottom-card-container">
        <div class="container">
            <div class="row">
                <div class="col-12 mt-3">
                    <h1 class="guest-bottom-heading">Health Tips</h1>
                    <hr>
                </div>

                

                <!-- Card 1 -->
                <div class="col-4 mt-3">
                    <div class="stay-hydrated-card  text-center guest-card shadow "  onlclick="display('section-Stay-Hydrated')">
                        <img class="w-100 P-1" src="Images/get-hydrated.jpeg"/>
                        <h1 class="guest-card-heading mt-3">Stay Hydrated</h1>
                        <p class="guest-card-paragraph pl-3 pr-3">
                            Drink at least 8 glasses of water a day to keep your body hydrated and functioning properly.
                        </p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-4 mt-3">
                    <div class="enough-sleep-card text-center guest-card shadow">
                        <img class="w-100 P-1" src="Images/enough-sleep.jpeg"/>
                        <h1 class="guest-card-heading mt-3">Enough Sleep</h1>
                        <p class="guest-card-paragraph pl-3 pr-3">
                            Get 7–9 hours of quality sleep each night to support overall health and energy levels.
                        </p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-4 mt-3">
                    <div class="manage-stress-card text-center guest-card shadow">
                        <img class="w-100 P-1" src="Images/manage-strees.jpeg"/>
                        <h1 class="guest-card-heading mt-3">Manage Stress</h1>
                        <p class="guest-card-paragraph pl-3 pr-3">
                            Practice relaxation techniques like meditation and deep breathing to reduce stress.
                        </p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col-4 mt-3 mb-5">
                    <div class="manage-stress-card text-center guest-card shadow">
                        <img class="w-100 P-2" src="Images/Eat More Greens.jpeg"/>
                        <h1 class="guest-card-heading mt-3">Eat More Greens</h1>
                        <p class="guest-card-paragraph pl-3 pr-3">
                            Add more green vegetables to your meals for better immunity and overall health.
                        </p>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="col-4 mt-3 mb-5">
                    <div class="manage-stress-card text-center guest-card shadow">
                        <img class="w-100 P-1" src="Images/Regular Exercise.jpeg"/>
                        <h1 class="guest-card-heading mt-3">Regular Exercise</h1>
                        <p class="guest-card-paragraph pl-3 pr-3">
                            
                            Daily physical activity strengthens your body and reduces disease risk.
                        </p>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="col-4 mt-3 mb-5">
                    <div class="manage-stress-card text-center guest-card shadow">
                        <img class="w-100 P-1" src="Images/Healthy Snacks.jpeg"/>
                        <h1 class="guest-card-heading mt-3">Healthy Snacks</h1>
                        <p class="guest-card-paragraph pl-3 pr-3">
                            Choose nutritious snacks to maintain energy and avoid unhealthy cravings.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>



    <div id="section-Stay-Hydrated">
        <div class="stay-hydrated-container">
            <div class="container">
                <div class="row">
                    <div class="col-12 p-5">
                        <img class="stay-hydrated-image w-100 p-2" src="Images/get-hydrated.jpeg"/>
                        <div class="guest-card-content shadow-lg">
                            <h1 class="stay-hydrated-heading p-2 pl-3">Stay Hydrated</h1>
                            <hr>
                            <p class="stay-hydrated-paragraph p-2 pl-3">
                                Proper hydration keeps your body functioning efficiently and boosts daily performance.

                                Water is essential for almost every function in the human body. It helps regulate body temperature, supports digestion, transports nutrients, and removes waste through urine and sweat. Staying properly hydrated improves concentration, prevents fatigue, and keeps your skin healthy. Even slight dehydration can lead to headaches, dizziness, and reduced productivity.

                            <br><br>
                                Drinking enough water daily supports physical performance and muscle recovery. When you exercise, your body loses fluids through sweat, and replenishing them is crucial to maintain energy and endurance. Proper hydration also aids metabolism, which can help in weight management.

                                <br><br>
                                
                                Experts generally recommend consuming 7–8 glasses of water per day, but individual needs may vary depending on climate, physical activity, and overall health. You can improve hydration habits by carrying a water bottle, setting reminders, or drinking a glass of water before every meal.

                                In addition to water, hydrating foods like watermelon, oranges, cucumbers, and coconut water can also contribute to fluid intake. Making hydration a daily priority leads to better physical and mental well-being.

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script
      type="text/javascript"
      src="https://d2clawv67efefq.cloudfront.net/ccbp-static-website/js/ccbp-ui-kit.js"
    ></script>
</body>
</html>