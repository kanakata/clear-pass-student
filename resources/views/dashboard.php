<?php loadHeader("dashboard") ?>

<nav>
    <h2><img src="./assets/icons/dashboard.png" alt="">Student dashboard</h2>
    <div class="links">
        <div class="mode">
            <div class="mode_set"></div>
        </div>
        <div class="sun_moon">
            <img src="./assets/icons/sun.png" alt="" class="weather">
        </div>
        <a href="/logout"><img src="./assets/icons/logout.png" alt="">log out</a>
        <a href="#footer"><img src="./assets/icons/customer-service.png" alt="">contact us</a>
    </div>
</nav>

<h2 class="welcome">Hii👋there <?= e($studentInfo['username']) ?> congratulations for completing your four year course. Welcome to your dash board.</h2>

<div class="details">
    <div><img src="./assets/icons/dashboard.png" alt="">Student Dashboard</div>
    <div><img src="./assets/icons/name.png" alt="">name: <?= e($studentInfo['username']) ?></div>
    <div><img src="./assets/icons/admission.png" alt="">admission: <?= e($studentInfo['admission number']) ?></div>
    <div><img src="./assets/icons/index.png" alt="">index: <?= e($studentInfo['index number']) ?></div>
</div>

<div class="t-holder">
    <div class="tutorial">
        <h1>We're glad you're here to begin your clearance process.</h1>
        <h2>This system is designed to make your final steps with us quick, clear, and efficient.</h2>
        <h3>What You Can Do Here :</h3>
        <ol>
            <li>View your status : See exactly which departments (e.g., Library, Finance & laboratory) still require your clearance.</li>
            <li>Resolve holds : Find instructions and contact studentInformation for any outstanding obligations you may have.</li>
            <li>Complete debts : Submit any necessary debts online through safaricom m-pesa through the school's paybill.</li>
        </ol>
        <h1>please note :</h1>
        <h2 class="red">1. Your final clearance status will be issued only after all departments have confirmed that you have met all your obligations.</h2>
        <h2 class="red">2. You should not forget your allocated clearance date !!!! . In case you do, you can always log in to confirm the date. <span style="color: green;"><b> And if you cant make it to collect your documents on the allocated date,</b></span> make sure you communicate to to be allocated another day.</h2>
        <h3>Ready to get started? proceed to the departments bellow.</h3>
    </div>
</div>

<div class="date">

    <?php if (!isset($_COOKIE['report_day'])): ?>
        <h2><img src="./assets/icons/year.png" alt="">Your pic up date will be displayed here once your clearance is complete.</h2>
    <?php endif; ?>

    <?php if (isset($_COOKIE['report_day'])): ?>
        <h2><img src="./assets/icons/year.png" alt="">Your pic up date is on: <?= e($_COOKIE['report_day']) ?></h2>
    <?php endif; ?>

    <?php if ($totalPercentage == 100 && !in_array("pending_physical_clearance", $status)): ?>
        <h2><img src="./assets/icons/fast-delivery.png" alt="shipment.png"><a href="/payShipment">Request shipment of my documents to my location.</a></h2>
        <?php if (true): ?>
            <h2><img src="./assets/icons/year.png" alt="">Your pic up location, if you request shipment, will be displayed here.</h2>
        <?php endif; ?>
    <?php else: ?>
        <h2 style="color: green;"><img src="./assets/icons/fast-delivery.png" alt="shipment.png">Complete clearance to request shipment for your documents.</h2>
    <?php endif; ?>

    <h2><img src="./assets/icons/pending.png" alt="cleared.png">Your clearance progress is: <span><?php echo $totalPercentage ?>%</span></h2>

</div>

<div class="res-holder">
    <h2>Proceed as you wish, the order doesn't realy matter. Happy clearance 😊.</h2>
</div>

<div class="sdash">

    <?php foreach ($departments as $department): ?>
        <a href="/department?department=<?= e($department)  ?>" class="dept
        <?php
        if ($studentInfo[$department . ' status'] == "cleared" || $studentInfo[$department . ' status'] == "online" || $studentInfo[$department . ' status'] == "pending_physical_payment") {
            echo "complete";
        } else {
            echo "";
        }
        ?>">
            <div class="percentage">
                <?php
                if ($studentInfo[$department . ' status'] == "cleared" || $studentInfo[$department . ' status'] == "online" || $studentInfo[$department . ' status'] == "pending_physical_payment") {
                    echo "100% cleared";
                } else {
                    echo "0% cleared";
                }
                ?></div>
            <div class="stat"><?= e($studentInfo[$department . ' status']) ?> </div>
            <div class="department"><img src="./assets/icons/<?= e($department) ?>.png" alt=""><?= e($department) ?></div>
        </a>
    <?php endforeach; ?>

</div>

<?php require_once ROOT . "/require/footer.php"; ?>
