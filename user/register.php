<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Dashboard</title>
    
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
    <script src="https://kit.fontawesome.com/ccc7436e56.js" crossorigin="anonymous"></script>
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="register-dashboard.css">
</head>
<body>
    <!-- Register Navigation Bar -->
    <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <a class="navbar-brand" href="#"><img class="guest-nav-image" src="../images/logo.jpeg"/><span class="guest-navbar-heading pt-5">Health & Wellness</span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ml-auto">
                <a class="nav-link active mr-3" id="gnavitem1" href="#">Dashboard <span class="sr-only">(current)</span></a>
                <a class="nav-link mr-3" id="gnavitem2" href="#">Manage Plans</a>
                <a class="nav-link mr-3" id="gnavitem3" href="#">Workout Library</a>
                <a class="nav-link mr-3" id="gnavitem4" href="#">Support</a>
                <a class="nav-link bg-success mr-3 text-white" id="gnavitem6" href="../login.php">Logout</a>
                </div>
            </div>
            </nav>
    </div>

      

    <!-- Register Dashboard Content -->
    <div class="container-fluid">
      <div class="row" style="height:100vh;">

        <!-- Sidebar -->
        <div class="col-2 bg-success">
          <div class="sticky-top"> 
            <nav class="nav flex-column mt-3 sidebar">

            <a class="nav-link active sidebar-link" style="white-space: nowrap;" href="#">
              <i class="fa-solid fa-gauge mr-2"></i> <span class="d-none d-sm-inline ms-2">Dashboard</span>
            </a>

            <hr class="sidebar-divider">

            <a class="nav-link sidebar-link" style="white-space: nowrap;" href="#">
              <i class="fa-solid fa-bowl-food mr-2"></i> <span class="d-none d-sm-inline ms-2">Meal Plans</span>
            </a>

            <a class="nav-link sidebar-link" style="white-space: nowrap;" href="#">
              <i class="fa-solid fa-dumbbell mr-2"></i> <span class="d-none d-sm-inline ms-2">Exercise Plans</span>
            </a>

            <a class="nav-link sidebar-link" style="white-space: nowrap;" href="#">
              <i class="fa-solid fa-bars-progress mr-2"></i> <span class="d-none d-sm-inline ms-2">Progress Data</span>
            </a>

            <a class="nav-link sidebar-link" style="white-space: nowrap;" href="#">
              <i class="fa-solid fa-lightbulb mr-2"></i> <span class="d-none d-sm-inline ms-2">SUBI Tips</span>
            </a>

            <a class="nav-link sidebar-link" style="white-space: nowrap;" href="#">
              <i class="fa-solid fa-right-from-bracket mr-2"></i> <span class="d-none d-sm-inline ms-2">Logout</span>
            </a>

          </nav>
          </div>
        </div>

        <!-- Main Content -->

        <!--Stat card-->
        <div class="col-lg-10 p-4">
           <div class="row g-4 mb-4">

            <div class="col-md-3">
              <div class="card stat-card p-3 text-white">
                <h6>Total Sessions</h6>
                <h3>1,250</h3>
                <small>Sessions completed</small>
              </div>
            </div>

            <div class="col-md-3">
              <div class="card stat-card p-3 text-white">
                <h6>Credits Balance</h6>
                <h3>850</h3>
                <small>Available credits</small>
              </div>
            </div>

            <div class="col-md-3">
              <div class="card stat-card p-3 text-white">
                <h6>Days Active</h6>
                <h3>12</h3>
                <small>This month</small>
              </div>
            </div>

            <div class="col-md-3">
              <div class="card stat-card p-2 text-white">
                <h6>Motivation</h6>
                <h3>Stay Consistent</h3>
                <p>Stay Focused</p>
              </div>
            </div>

          </div>
      </div>
    </div>



    <script type="text/javascript" src="https://new-assets.ccbp.in/frontend/content/static-ccbp-ui-kit/static-ccbp-ui-kit.js"></script>

</body>
</html>