<?php
$title = "Home";
$css = "guest.css"; 

ob_start();
?>

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

        <div class="guest-banner-container align-items-center">
            <div class="guest-banner-content">
                <h1 class="guest-banner-heading">Stay Fit, Stay Healthy!</h1>
                <p class="guest-banner-paragraph">Enjoy fitness, meal plans, and Wellness Boosts</p>
                <button class="get-started-button shadow-lg" onclick="window.location.href='register.php'">Get Started</button>
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
                        <div class="stay-hydrated-card  text-center guest-card shadow" onclick="display('section-Stay-Hydrated')">
                            <img class="w-100 P-1" src="images/get-hydrated.jpeg"/>
                            <h1 class="guest-card-heading mt-3">Stay Hydrated</h1>
                            <p class="guest-card-paragraph pl-3 pr-3">
                                Drink at least 8 glasses of water a day to keep your body hydrated and functioning properly.
                            </p>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="col-4 mt-3">
                        <div class="enough-sleep-card text-center guest-card shadow" onclick="display('section-Enough-Sleep')">
                            <img class="w-100 P-1" src="images/enough-sleep.jpeg"/>
                            <h1 class="guest-card-heading mt-3">Enough Sleep</h1>
                            <p class="guest-card-paragraph pl-3 pr-3">
                                Get 7–9 hours of quality sleep each night to support overall health and energy levels.
                            </p>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="col-4 mt-3">
                        <div class="manage-stress-card text-center guest-card shadow"  onclick="display('section-Manage-Stress')">
                            <img class="w-100 P-1" src="images/manage-stress.jpeg"/>
                            <h1 class="guest-card-heading mt-3">Manage Stress</h1>
                            <p class="guest-card-paragraph pl-3 pr-3">
                                Practice relaxation techniques like meditation and deep breathing to reduce stress.
                            </p>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="col-4 mt-3 mb-5">
                        <div class="manage-stress-card text-center guest-card shadow" onclick="display('section-Eat-More-Greens')">
                            <img class="w-100 P-2" src="Images/Eat More Greens.jpeg"/>
                            <h1 class="guest-card-heading mt-3">Eat More Greens</h1>
                            <p class="guest-card-paragraph pl-3 pr-3">
                                Add more green vegetables to your meals for better immunity and overall health.
                            </p>
                        </div>
                    </div>

                    <!-- Card 5 -->
                    <div class="col-4 mt-3 mb-5">
                        <div class="manage-stress-card text-center guest-card shadow" onclick="display('section-Regular-Exercise')">
                            <img class="w-100 P-1" src="Images/Regular Exercise.jpeg"/>
                            <h1 class="guest-card-heading mt-3">Regular Exercise</h1>
                            <p class="guest-card-paragraph pl-3 pr-3">
                                
                                Daily physical activity strengthens your body and reduces disease risk.
                            </p>
                        </div>
                    </div>

                    <!-- Card 6 -->
                    <div class="col-4 mt-3 mb-5">
                        <div class="manage-stress-card text-center guest-card shadow" onclick="display('section-Healthy-Snacks')">
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
    </div>
 

    <!-- Stay Hydrated Section -->
     <div id="section-Stay-Hydrated">

        <div class="stay-hydrated-container bg-white mb-3">
            <div class="container">
                <div class="row">
                    <div class="col-12 p-5 d-flex flex-row">
                        <div>
                            <img class="stay-hydrated-image w-100 p-2" src="Images/get-hydrated.jpeg"/>
                        </div>
                        <div class="guest-card-content shadow-lg">
                            <h1 class="stay-hydrated-heading p-2 pl-3 " style="font-family: Roboto;">Stay Hydrated</h1>
                            <hr>
                            <p class="stay-hydrated-paragraph p-2 pl-3 " style="font-family: Roboto;">
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
                <button class="get-started-button shadow-lg d-none d-block-lg " onclick="display('sectionGuest')">Back</button>
            </div>
        </div>
    </div>

    <!-- Enough sleep Section -->
     <div id="section-Enough-Sleep">

        <div class="enough-sleep-container bg-white mb-3">
            <div class="container">
                <div class="row">
                    <div class="col-12 p-5 d-flex flex-row">
                        <div>
                            <img class="enough-sleep-image w-100 p-2" src="images/enough-sleep.jpeg"/>
                        </div>
                        <div class="guest-card-content shadow-lg">
                            <h1 class="enough-sleep-heading p-2 pl-3">Get Enough Sleep</h1>
                            <hr>
                            <p class="enough-sleep-paragraph p-2 pl-3">
                               Quality sleep improves focus, recovery, and long-term health.

                               Sleep plays a vital role in maintaining both physical and mental health. During sleep, the body repairs damaged tissues, strengthens the immune system, and restores energy levels. It also supports brain function by enhancing memory, learning ability, and emotional balance. Adults generally require 7–9 hours of quality sleep per night for optimal performance.
                            <br><br>
                                Lack of sleep can negatively impact concentration, mood, and decision-making abilities. Over time, sleep deprivation increases the risk of obesity, heart disease, and weakened immunity. Poor sleep habits can also disrupt hormones that regulate hunger, leading to overeating and weight gain.

                                <br><br>
                                
                                Improving sleep quality starts with creating a consistent routine. Going to bed and waking up at the same time every day helps regulate your body clock. Avoiding screens, caffeine, and heavy meals before bedtime can also improve sleep patterns.

                                A comfortable sleep environment with low light and minimal noise further enhances rest. Prioritizing sleep is not laziness—it is an investment in better productivity, mental clarity, and long-term health.
                            </p>
                        </div>
                    
                    </div>
                </div>
                <button class="get-started-button shadow-lg" onclick="display('sectionGuest')">Back</button>
            </div>
        </div>
    </div>

    <!-- Manage Stress Section -->
     <div id="section-Manage-Stress">

        <div class="manage-stress-container bg-white mb-3">
            <div class="container">
                <div class="row">
                    <div class="col-12 p-5 d-flex flex-row">
                        <div>
                            <img class="manage-stress-image w-100 p-2" src="images/manage-stress.jpeg"/>
                        </div>
                        <div class="guest-card-content shadow-lg">
                            <h1 class="manage-stress-heading p-2 pl-3">Manage Stress</h1>
                            <hr>
                            <p class="manage-stress-paragraph p-2 pl-3">
                               Managing stress is essential for maintaining emotional and physical balance.

                               Stress is a natural response to challenging situations, but prolonged stress can negatively impact health. Chronic stress can lead to headaches, digestive problems, sleep disturbances, and even heart-related issues. It also affects mental clarity and emotional stability, making it harder to concentrate and stay productive.
                                <br><br>
                                Effective stress management improves both mental and physical well-being. Techniques such as deep breathing exercises, meditation, yoga, and mindfulness can help calm the mind and reduce anxiety. Regular physical activity and proper sleep also play a major role in controlling stress levels.

                                <br><br>
                                
                                Time management and setting realistic goals reduce unnecessary pressure. Taking short breaks during work, engaging in hobbies, and spending time with loved ones can significantly lower stress levels. Disconnecting from digital devices occasionally also improves mental peace.

                                Learning to manage stress does not eliminate challenges but helps you handle them more effectively. A balanced mind leads to better decision-making, stronger relationships, and improved overall health.
                            </p>
                        </div>
                    
                    </div>
                </div>
                <button class="get-started-button shadow-lg" onclick="display('sectionGuest')">Back</button>
            </div>
        </div>
    </div>

    <!-- Eat More Greens Section -->
     <div id="section-Eat-More-Greens">

        <div class="eat-more-greens-container bg-white mb-3">
            <div class="container">
                <div class="row">
                    <div class="col-12 p-5 d-flex flex-row">
                        <div>
                            <img class="eat-more-greens-image w-100 p-2" src="images/Eat More Greens.jpeg"/>
                        </div>
                        <div class="guest-card-content shadow-lg">
                            <h1 class="eat-more-greens-heading p-2 pl-3">Eat More Greens</h1>
                            <hr>
                            <p class="eat-more-greens-paragraph p-2 pl-3">
                               Add more green vegetables to your meals for better immunity and overall health.

                               Green vegetables are one of the most powerful natural sources of essential nutrients. They are rich in vitamins A, C, and K, along with iron, calcium, and antioxidants that help strengthen the immune system. Leafy greens such as spinach, kale, broccoli, and lettuce also contain high fiber content, which improves digestion and promotes gut health. A diet rich in greens helps reduce inflammation and supports long-term wellness.
                                <br><br>
                                Including greens in your daily diet can significantly lower the risk of chronic diseases such as heart disease, diabetes, and obesity. The antioxidants present in green vegetables help fight free radicals in the body, reducing cell damage and slowing down aging. They also contribute to better skin health and improved energy levels throughout the day.

                                <br><br>
                                You don’t need to completely change your diet to start eating healthier. Begin with small steps like adding spinach to your sandwiches, including a side salad with lunch, or blending greens into smoothies. Gradually increasing your intake makes the habit sustainable and easier to maintain.

                                Consistency is the key. Aim to include at least one serving of green vegetables in every meal to build a strong foundation for lifelong health.
                            </p>
                        </div>
                    
                    </div>
                </div>
                <button class="get-started-button shadow-lg" onclick="display('sectionGuest')">Back</button>
            </div>
        </div>
    </div>

    <!-- Regular Exercise Section -->
     <div id="section-Regular-Exercise">

        <div class="regular-exercise-container bg-white mb-3">
            <div class="container">
                <div class="row">
                    <div class="col-12 p-5 d-flex flex-row">
                        <div>
                            <img class="regular-exercise-image w-100 p-2" src="images/Regular Exercise.jpeg"/>
                        </div>
                        <div class="guest-card-content shadow-lg">
                            <h1 class="regular-exercise-heading p-2 pl-3">Regular Exercise</h1>
                            <hr>
                            <p class="regular-exercise-paragraph p-2 pl-3">
                               Daily physical activity strengthens your body and reduces disease risk.

                               Regular exercise is one of the most effective ways to maintain a healthy lifestyle. Physical activity strengthens the heart, improves blood circulation, builds muscle, and increases flexibility. It also helps maintain a healthy body weight and reduces the risk of chronic illnesses such as diabetes, high blood pressure, and cardiovascular diseases.

                               <br><br>
                                Exercise has significant mental health benefits as well. Physical activity releases endorphins, commonly known as “feel-good hormones,” which help reduce stress, anxiety, and depression. Regular workouts improve mood, boost confidence, and increase overall energy levels.

                                <br><br>
                                
                                You don’t need intense gym sessions to stay fit. Activities like brisk walking, jogging, cycling, yoga, or home workouts are equally effective when done consistently. Even 30 minutes of moderate exercise five times a week can bring noticeable improvements.

                                The key is consistency and gradual progression. Start with achievable goals and increase intensity slowly. Making exercise a regular part of your routine builds discipline and promotes long-term physical and mental wellness.
                            </p>
                        </div>
                    
                    </div>
                </div>
                <button class="get-started-button shadow-lg" onclick="display('sectionGuest')">Back</button>
            </div>
        </div>
    </div>

    <!-- Healthy Snacks Section -->
     <div id="section-Healthy-Snacks">

        <div class="healthy-snacks-container bg-white mb-3">
            <div class="container">
                <div class="row">
                    <div class="col-12 p-5 d-flex flex-row">
                        <div>
                            <img class="healthy-snacks-image w-100 p-2" src="images/Healthy Snacks.jpeg"/>
                        </div>
                        <div class="guest-card-content shadow-lg">
                            <h1 class="healthy-snacks-heading p-2 pl-3">Healthy Snacks</h1>
                            <hr>
                            <p class="healthy-snacks-paragraph p-2 pl-3">
                               Choose nutritious snacks to maintain energy and avoid unhealthy cravings.
                               Snacking is a common habit, but choosing the right snacks makes a big difference in overall health. Healthy snacks provide essential nutrients and sustained energy without causing sudden spikes in blood sugar levels. Options such as fruits, nuts, yogurt, boiled eggs, and whole-grain snacks are excellent choices.
                                <br><br>
                                Unhealthy snacks high in sugar and processed ingredients can lead to weight gain, fatigue, and long-term health problems. Replacing chips and sugary drinks with healthier alternatives supports better metabolism and digestion. Nutritious snacks also help control hunger between meals and prevent overeating.

                                <br><br>
                               Planning your snacks in advance is a smart strategy. Keeping healthy options easily accessible reduces the temptation to choose junk food. Portion control is equally important to maintain balance and avoid excess calorie intake.

                                Making mindful snacking choices contributes to a healthier lifestyle. Small daily improvements in diet can lead to significant long-term benefits for your body and mind.
                            </p>
                        </div>
                    
                    </div>
                </div>
                <button class="get-started-button shadow-lg" onclick="display('sectionGuest')">Back</button>
            </div>
        </div>
    </div>

     <script type="text/javascript" src="https://new-assets.ccbp.in/frontend/content/static-ccbp-ui-kit/static-ccbp-ui-kit.js"></script>




</body>
</html>

<?php
$content = ob_get_clean();
include("includes/layout.php");
?>
