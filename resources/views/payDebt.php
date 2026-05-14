<?php loadHeader($_GET['department']) ?>
<nav>
    <?php if (isset($_GET['department'])): ?>
        <h2><img src="./assets/icons/dashboard.png" alt="">Pay <?= e($_GET['department']) ?> online</h2>
    <?php else: ?>
        <h2><img src="./assets/icons/dashboard.png" alt="">request shipment</h2>
    <?php endif; ?>
    <div class="links">
        <div class="mode">
            <div class="mode_set"></div>
        </div>
        <div class="sun_moon">
            <img src="/assets/sun.png" alt="" class="weather">
        </div>
        <!-- <a href="<?= e($_SERVER['HTTP_REFERER']) ?>"><img src="./assets/icons/back.png" alt="">Back</a> -->
    </div>
</nav>

<div class="actions">

    <h2 class="welcome" style="color: green;">Enter you phone number and password to Complete your transaction.</h2>
    <div class="forms">
        <form action="" method="POST">
            <h2><img src="./assets/icons/online-payment.png" alt="">Make online payment</h2>
            <label for="username">
                <img src="./assets/icons/user.png" alt="">
                <input type="text" value="Username: <?php echo $studentInfo['username'] ?>" name="username" readonly>
            </label>
            <label for="admission">
                <img src="./assets/icons/admission.png" alt="">
                <input type="text" name="admission" value="Admission: <?php echo $studentInfo['admission number'] ?>" readonly>
            </label>
            <label for="phone">
                <img src="./assets/icons/index.png" alt="">
                <input type="text" name="phone" placeholder="phone (254712345678)" required>
            </label>
            <label for="item">
                <img src="./assets/icons/lost-items.png" alt="">
                <input type="text" name="lost_item" value="Debt: <?php echo $studentInfo[$_GET['department'] . " debt"] ?>" readonly>
            </label>
            <label for="">
                <img src="./assets/icons/value.png" alt="">
                <input type="text" name="amount" value="Ksh: <?php echo $studentInfo[$_GET['department'] . " value"] ?>" readonly>
            </label>
            <!-- <label for="password">
                    <img src="./assets/icons/password.png" alt="">
                    <input type="password" name="password" placeholder="password" required>
                </label> -->
            <input type="submit" value="Make payment" name="online_payment">
        </form>
    </div>

</div>


<?php loadFooter() ?>
