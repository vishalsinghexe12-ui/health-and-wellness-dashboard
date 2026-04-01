<?php
// seed_plans.php
try {
    $con = mysqli_connect("localhost", "root", "");
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error() . "\n");
    }
    echo "Connected to MySQL successfully.\n";

    // Create database first if it doesn't exist
    mysqli_query($con, "CREATE DATABASE IF NOT EXISTS health_and_wellness");
    echo "Database 'health_and_wellness' ensured.\n";

    // Now select it
    mysqli_select_db($con, "health_and_wellness");
    
    // Drop tables to recreate them with new schemas
    mysqli_query($con, "DROP TABLE IF EXISTS register");
    mysqli_query($con, "DROP TABLE IF EXISTS plans");
    mysqli_query($con, "DROP TABLE IF EXISTS password_token");
    mysqli_query($con, "DROP TABLE IF EXISTS contact_messages");
    echo "Dropped existing tables.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Close the connection before db_config creates a new one
mysqli_close($con);

// Include db config to trigger table creations
require_once("db_config.php");
echo "Tables created via db_config.php.\n";

// Insert Wellness Plans
$plans = [
    [
        'title' => 'Beginner Plan',
        'type' => 'Wellness',
        'description' => 'Basic Yoga • 10 Min Daily Exercise • Water tracking',
        'category' => 'Healthy Habits',
        'duration' => '4 Weeks',
        'calories' => '',
        'intensity' => '',
        'price' => 499,
        'image_path' => 'images/beautiful-girls-are-playing-yoga-park.jpg'
    ],
    [
        'title' => 'Fitness Plan',
        'type' => 'Wellness',
        'description' => 'Strength Training • Daily step tracking • Workout Schedule',
        'category' => 'Improve Strength',
        'duration' => '8 Weeks',
        'calories' => '',
        'intensity' => '',
        'price' => 799,
        'image_path' => 'images/Guest-Img-5.jpeg'
    ],
    [
        'title' => 'Diet Plan',
        'type' => 'Wellness',
        'description' => 'Healthy Meals • Water goals • Nutrition tips',
        'category' => 'Improve Nutrition',
        'duration' => '4 Weeks',
        'calories' => '',
        'intensity' => '',
        'price' => 599,
        'image_path' => 'images/vegetable-image.jpeg'
    ],
    [
        'title' => 'Mental Wellness Plan',
        'type' => 'Wellness',
        'description' => 'Meditation • Sleep tracking • Stress Management',
        'category' => 'Reduce stress',
        'duration' => '6 Weeks',
        'calories' => '',
        'intensity' => '',
        'price' => 899,
        'image_path' => 'images/woman-lotus-pose-park.jpg'
    ],
    
    // Meal Plans
    [
        'title' => 'Low Carb Plan',
        'type' => 'Meal',
        'description' => 'Reduce carbs to promote fat burning and stable energy levels.',
        'category' => 'Weight Loss',
        'duration' => '',
        'calories' => '1,500 kcal/day',
        'intensity' => '',
        'price' => 2499,
        'image_path' => 'meal-plans-images/weight loss.jpg'
    ],
    [
        'title' => 'High Protein Plan',
        'type' => 'Meal',
        'description' => 'Increase protein intake to support muscle growth and recovery.',
        'category' => 'Muscle Gain',
        'duration' => '',
        'calories' => '2,500 kcal/day',
        'intensity' => '',
        'price' => 2999,
        'image_path' => 'meal-plans-images/High Protien.jpg'
    ],
    [
        'title' => 'Keto Plan',
        'type' => 'Meal',
        'description' => 'Limit carbohydrates to enhance fat burning and enter ketosis quickly.',
        'category' => 'Weight Loss',
        'duration' => '',
        'calories' => '1,800 kcal/day',
        'intensity' => '',
        'price' => 2799,
        'image_path' => 'meal-plans-images/keto meal.jpg'
    ],
    [
        'title' => 'Vegan Plan',
        'type' => 'Meal',
        'description' => 'Plant-based meals for better digestion, energy, and overall health.',
        'category' => 'Healthy Lifestyle',
        'duration' => '',
        'calories' => '1,700 kcal/day',
        'intensity' => '',
        'price' => 2499,
        'image_path' => 'meal-plans-images/Vegan meal.jpg'
    ],
    [
        'title' => 'Muscle Gain Pro',
        'type' => 'Meal',
        'description' => 'Increase calories with rich nutrients to maximize muscle mass predictably.',
        'category' => 'Bulking',
        'duration' => '',
        'calories' => '2,800 kcal/day',
        'intensity' => '',
        'price' => 3299,
        'image_path' => 'meal-plans-images/muscle gain.jpg'
    ],
    [
        'title' => 'Balanced Diet',
        'type' => 'Meal',
        'description' => 'Maintain a perfect macronutrient balance for steady daily energy.',
        'category' => 'General Fitness',
        'duration' => '',
        'calories' => '2,000 kcal/day',
        'intensity' => '',
        'price' => 2499,
        'image_path' => 'meal-plans-images/Balanced meal.jpg'
    ],
    
    // Exercise Plans
    [
        'title' => 'Weight Loss Plan',
        'type' => 'Exercise',
        'description' => 'High-intensity workouts designed to burn calories and shed weight fast.',
        'category' => 'Weight Loss',
        'duration' => '45 mins',
        'calories' => '',
        'intensity' => 'High',
        'price' => 3499,
        'image_path' => 'Exercise-Images/Weight loss fitness.jpg'
    ],
    [
        'title' => 'Muscle Building Plan',
        'type' => 'Exercise',
        'description' => 'Focused strength training to increase muscle mass and strength.',
        'category' => 'Muscle Building',
        'duration' => '60 mins',
        'calories' => '',
        'intensity' => 'Medium',
        'price' => 3999,
        'image_path' => 'Exercise-Images/muscle gain fitness.jpg'
    ],
    [
        'title' => 'Yoga & Flexibility',
        'type' => 'Exercise',
        'description' => 'Improve flexibility, balance, and mental clarity with guided yoga.',
        'category' => 'General Fitness',
        'duration' => '30 mins',
        'calories' => '',
        'intensity' => 'Low',
        'price' => 2999,
        'image_path' => 'Exercise-Images/Full Body Workout.jpg'
    ],
    [
        'title' => 'HIIT Intensity',
        'type' => 'Exercise',
        'description' => 'Short, intense bursts of exercise followed by brief recovery periods.',
        'category' => 'Advanced',
        'duration' => '25 mins',
        'calories' => '',
        'intensity' => 'Very High',
        'price' => 3699,
        'image_path' => 'Exercise-Images/HIIT Blast.jpg'
    ],
    [
        'title' => 'Endurance Plan',
        'type' => 'Exercise',
        'description' => 'Building cardiovascular strength and long-term stamina.',
        'category' => 'Intermediate',
        'duration' => '50 mins',
        'calories' => '',
        'intensity' => 'Medium',
        'price' => 3299,
        'image_path' => 'Exercise-Images/Beginner Fitness.jpg'
    ],
    [
        'title' => 'Strength Pro',
        'type' => 'Exercise',
        'description' => 'In-depth resistance training for total body strength and power.',
        'category' => 'Advanced',
        'duration' => '60 mins',
        'calories' => '',
        'intensity' => 'High',
        'price' => 3999,
        'image_path' => 'Exercise-Images/Strenght.jpg'
    ]
];

foreach ($plans as $p) {
    $stmt = $con->prepare("INSERT INTO plans (title, type, description, category, duration, calories, intensity, price, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $p['title'], $p['type'], $p['description'], $p['category'], $p['duration'], $p['calories'], $p['intensity'], $p['price'], $p['image_path']);
    if ($stmt->execute()) {
        echo "Inserted " . $p['title'] . "\n";
    } else {
        echo "Error inserting " . $p['title'] . ": " . $stmt->error . "\n";
    }
}

// Optional: Insert an admin user since we dropped `register`
$admin_pw = "admin123";
$stmt = $con->prepare("INSERT INTO register (name, email, password, role, status) VALUES ('Admin User', 'admin@example.com', ?, 'admin', 'Active')");
$stmt->bind_param("s", $admin_pw);
if ($stmt->execute()) {
    echo "Inserted admin test user\n";
}

// Optional: Insert a regular user
$user_pw = "user123";
$stmt = $con->prepare("INSERT INTO register (name, email, password, role, status) VALUES ('Test User', 'user@example.com', ?, 'user', 'Active')");
$stmt->bind_param("s", $user_pw);
if ($stmt->execute()) {
    echo "Inserted regular test user\n";
}

echo "Database successfully populated!\n";
?>
