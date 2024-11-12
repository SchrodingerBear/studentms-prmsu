<style>
  .brand-title {
    display: block;
    font-size: 24px;
  }

  .brand-img {
    display: block;
  }

  .navbar-header {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
  }

  .brand {
    margin-right: auto;
  }

  /* Default styling for navbar links */
  .navbar-default .navbar-nav>li>a {
    color: #000 !important;
    font-weight: bold !important;
    padding: 10px 15px;
    transition: background-color 0.3s ease;
    white-space: nowrap;
    /* Prevent line breaks within links */
  }

  /* Hover, focus, and active effects */
  .navbar-default .navbar-nav>li>a:hover,
  .navbar-default .navbar-nav>li>a:focus,
  .navbar-default .navbar-nav>li.active>a {
    color: #fff !important;
    background-color: #2793FD !important;
  }

  .navbar-default .navbar-nav>li>a:active {
    color: #fff !important;
    background-color: #1A73E8 !important;
  }

  /* Mobile adjustments */
  @media (max-width: 768px) {
    .brand-title {
      font-size: 16px;
    }

    /* Adjust font size and padding of navbar links for mobile */
    .navbar-default .navbar-nav>li>a {
      font-size: 14px;
      padding: 8px 10px;
    }

    /* Ensure proper spacing for the brand and title */
    .brand {
      gap: 0.5rem;
    }

    .navbar-toggle {
      margin-top: 5px;
      margin-bottom: 5px;
    }
  }
</style>

<div class="header" id="home">
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <div class="brand" style="display: flex; flex-direction: row; align-items: center; gap: 1rem;">
          <img class="brand-img" style="width: 40px; height: 40px;" src='images/prmsu.png' />
          <h1 class="brand-title" style="color: #000; font-weight: bold;">PRMSU STA. CRUZ CAMPUS</h1>
        </div>

        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
          data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"> </span>
          <span class="icon-bar"> </span>
          <span class="icon-bar"> </span>
        </button>
      </div>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="index.php"><span data-hover="Home">Home</span></a></li>
          <li><a href="contact.php"><span data-hover="Contact">Contact</span></a></li>
          <li><a href="about.php"><span data-hover="About">About</span></a></li>
          <li><a href="user/login.php"><span data-hover="Admin">Login</span></a></li>
        </ul>
      </div>
  </nav>
</div>