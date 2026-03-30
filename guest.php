<?php
$title = "Health & Wellness - Home";
$css = "guest.css"; 

ob_start();
?>

<div class="guest-banner-container">
    <div class="guest-banner-content">
        <h1 class="guest-banner-heading">Stay Fit, Stay Healthy!</h1>
        <p class="guest-banner-paragraph">Enjoy fitness, meal plans, and Wellness Boosts designed to help you live your best life.</p>
        <button class="get-started-button shadow-lg" onclick="window.location.href='register.php'">Get Started Today</button>
    </div>
</div>

<div class="guest-card-container py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-5 text-center">
                <h1 class="guest-bottom-heading">Daily Health Tips</h1>
                <hr class="heading-hr mx-auto">
            </div>

            <!-- Card 1: Hydrated -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="guest-card" data-toggle="modal" data-target="#modalStayHydrated">
                    <img class="w-100" src="images/get-hydrated.jpeg" alt="Stay Hydrated"/>
                    <h2 class="guest-card-heading">Stay Hydrated</h2>
                    <p class="guest-card-paragraph">Drink at least 8 glasses of water a day to keep your body hydrated and functioning properly.</p>
                </div>
            </div>

            <!-- Card 2: Sleep -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="guest-card" data-toggle="modal" data-target="#modalEnoughSleep">
                    <img class="w-100" src="images/enough-sleep.jpeg" alt="Enough Sleep"/>
                    <h2 class="guest-card-heading">Enough Sleep</h2>
                    <p class="guest-card-paragraph">Get 7–9 hours of quality sleep each night to support overall health and energy levels.</p>
                </div>
            </div>

            <!-- Card 3: Stress -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="guest-card" data-toggle="modal" data-target="#modalManageStress">
                    <img class="w-100" src="images/manage-stress.jpeg" alt="Manage Stress"/>
                    <h2 class="guest-card-heading">Manage Stress</h2>
                    <p class="guest-card-paragraph">Practice relaxation techniques like meditation and deep breathing to reduce stress.</p>
                </div>
            </div>

            <!-- Card 4: Greens -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="guest-card" data-toggle="modal" data-target="#modalEatGreens">
                    <img class="w-100" src="Images/Eat More Greens.jpeg" alt="Eat More Greens"/>
                    <h2 class="guest-card-heading">Eat More Greens</h2>
                    <p class="guest-card-paragraph">Add more green vegetables to your meals for better immunity and overall health.</p>
                </div>
            </div>

            <!-- Card 5: Exercise -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="guest-card" data-toggle="modal" data-target="#modalRegularExercise">
                    <img class="w-100" src="Images/Regular Exercise.jpeg" alt="Regular Exercise"/>
                    <h2 class="guest-card-heading">Regular Exercise</h2>
                    <p class="guest-card-paragraph">Daily physical activity strengthens your body and reduces disease risk.</p>
                </div>
            </div>

            <!-- Card 6: Snacks -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="guest-card" data-toggle="modal" data-target="#modalHealthySnacks">
                    <img class="w-100" src="Images/Healthy Snacks.jpeg" alt="Healthy Snacks"/>
                    <h2 class="guest-card-heading">Healthy Snacks</h2>
                    <p class="guest-card-paragraph">Choose nutritious snacks to maintain energy and avoid unhealthy cravings.</p>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ================= MODALS ================= -->

<!-- Modal: Stay Hydrated -->
<div class="modal fade" id="modalStayHydrated" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Stay Hydrated</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-4">
        <img src="Images/get-hydrated.jpeg" class="w-100 mb-4" alt="Hydration">
        <p>Proper hydration keeps your body functioning efficiently and boosts daily performance.</p>
        <p>Water is essential for almost every function in the human body. It helps regulate body temperature, supports digestion, transports nutrients, and removes waste through urine and sweat. Staying properly hydrated improves concentration, prevents fatigue, and keeps your skin healthy. Even slight dehydration can lead to headaches, dizziness, and reduced productivity.</p>
        <p>Drinking enough water daily supports physical performance and muscle recovery. When you exercise, your body loses fluids through sweat, and replenishing them is crucial to maintain energy and endurance. Proper hydration also aids metabolism, which can help in weight management.</p>
        <p>Experts generally recommend consuming 7–8 glasses of water per day, but individual needs may vary depending on climate, physical activity, and overall health. You can improve hydration habits by carrying a water bottle, setting reminders, or drinking a glass of water before every meal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Enough Sleep -->
<div class="modal fade" id="modalEnoughSleep" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Get Enough Sleep</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-4">
        <img src="images/enough-sleep.jpeg" class="w-100 mb-4" alt="Sleep">
        <p>Quality sleep improves focus, recovery, and long-term health.</p>
        <p>Sleep plays a vital role in maintaining both physical and mental health. During sleep, the body repairs damaged tissues, strengthens the immune system, and restores energy levels. It also supports brain function by enhancing memory, learning ability, and emotional balance. Adults generally require 7–9 hours of quality sleep per night for optimal performance.</p>
        <p>Lack of sleep can negatively impact concentration, mood, and decision-making abilities. Over time, sleep deprivation increases the risk of obesity, heart disease, and weakened immunity. Poor sleep habits can also disrupt hormones that regulate hunger, leading to overeating and weight gain.</p>
        <p>Improving sleep quality starts with creating a consistent routine. Going to bed and waking up at the same time every day helps regulate your body clock. Avoiding screens, caffeine, and heavy meals before bedtime can also improve sleep patterns.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Manage Stress -->
<div class="modal fade" id="modalManageStress" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Manage Stress</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-4">
        <img src="images/manage-stress.jpeg" class="w-100 mb-4" alt="Stress">
        <p>Managing stress is essential for maintaining emotional and physical balance.</p>
        <p>Stress is a natural response to challenging situations, but prolonged stress can negatively impact health. Chronic stress can lead to headaches, digestive problems, sleep disturbances, and even heart-related issues. It also affects mental clarity and emotional stability, making it harder to concentrate and stay productive.</p>
        <p>Effective stress management improves both mental and physical well-being. Techniques such as deep breathing exercises, meditation, yoga, and mindfulness can help calm the mind and reduce anxiety. Regular physical activity and proper sleep also play a major role in controlling stress levels.</p>
        <p>Time management and setting realistic goals reduce unnecessary pressure. Taking short breaks during work, engaging in hobbies, and spending time with loved ones can significantly lower stress levels. Disconnecting from digital devices occasionally also improves mental peace.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Eat Greens -->
<div class="modal fade" id="modalEatGreens" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Eat More Greens</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-4">
        <img src="Images/Eat More Greens.jpeg" class="w-100 mb-4" alt="Greens">
        <p>Add more green vegetables to your meals for better immunity and overall health.</p>
        <p>Green vegetables are one of the most powerful natural sources of essential nutrients. They are rich in vitamins A, C, and K, along with iron, calcium, and antioxidants that help strengthen the immune system. Leafy greens such as spinach, kale, broccoli, and lettuce also contain high fiber content, which improves digestion and promotes gut health.</p>
        <p>Including greens in your daily diet can significantly lower the risk of chronic diseases such as heart disease, diabetes, and obesity. The antioxidants present in green vegetables help fight free radicals in the body, reducing cell damage and slowing down aging.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Regular Exercise -->
<div class="modal fade" id="modalRegularExercise" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Regular Exercise</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-4">
        <img src="Images/Regular Exercise.jpeg" class="w-100 mb-4" alt="Exercise">
        <p>Daily physical activity strengthens your body and reduces disease risk.</p>
        <p>Regular exercise is one of the most effective ways to maintain a healthy lifestyle. Physical activity strengthens the heart, improves blood circulation, builds muscle, and increases flexibility. It also helps maintain a healthy body weight and reduces the risk of chronic illnesses such as diabetes, high blood pressure, and cardiovascular diseases.</p>
        <p>Exercise has significant mental health benefits as well. Physical activity releases endorphins, commonly known as “feel-good hormones,” which help reduce stress, anxiety, and depression. Regular workouts improve mood, boost confidence, and increase overall energy levels.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Healthy Snacks -->
<div class="modal fade" id="modalHealthySnacks" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Healthy Snacks</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-4">
        <img src="Images/Healthy Snacks.jpeg" class="w-100 mb-4" alt="Snacks">
        <p>Choose nutritious snacks to maintain energy and avoid unhealthy cravings.</p>
        <p>Snacking is a common habit, but choosing the right snacks makes a big difference in overall health. Healthy snacks provide essential nutrients and sustained energy without causing sudden spikes in blood sugar levels. Options such as fruits, nuts, yogurt, boiled eggs, and whole-grain snacks are excellent choices.</p>
        <p>Unhealthy snacks high in sugar and processed ingredients can lead to weight gain, fatigue, and long-term health problems. Replacing chips and sugary drinks with healthier alternatives supports better metabolism and digestion. Nutritious snacks also help control hunger between meals and prevent overeating.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<?php
$content = ob_get_clean();
include("includes/layout.php");
?>
