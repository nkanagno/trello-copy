<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help | Trello</title>
    <link rel="icon" href="https://bxp-content-static.prod.public.atl-paas.net/img/favicon.ico">
    
    <!-- CSS styles (main theme, help) -->
    <link rel="stylesheet" href="./styles/theme.css">
    <link rel="stylesheet" href="./styles/help-public.css">

    <!-- js script (dark-light mode)-->
    <script src="./scripts/dark_light_mode.js" defer></script>
</head>
<body>
    <?php include './include/navbar.php';?>
    <header>
        <h1>Frequently Asked Questions</h1>
    </header>
    <section id="help-section">
        <div class="accordion">
          <div class="accordion-item">
                <button class="accordion-header">How do I register on the site?<span><img src='../assets/arrows-light.svg'></span></button>
                <div class="accordion-content">
                    <p>To register on the site, first click the "sign-up" option, then fill in the required fields. Your username must be up to 12 characters long and your password up to 16 characters.</p>
                </div>
            </div>
            <div class="accordion-item">
                <button class="accordion-header">How do I use the SimplePush key? <span><img src='../assets/arrows-light.svg'></span></button>
                <div class="accordion-content">
                    <p>During registration, you must fill in the "Simplepush.io Key" field. The Simplepush.io Key is the number provided by the SimplePush application. By downloading the application on an Android or iOS device, you gain the ability to receive confirmation messages while using the site's features.</p>
                </div>
            </div>
        </div>
    </section>
    <?php include './include/footer.php'; ?>
</body>
</html>