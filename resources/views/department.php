<?php loadHeader(e($dept)) ?>

<nav>
    <h2><img src="./assets/icons/<?= e($dept) ?>.png" alt=""><?= e($dept) ?></h2>
    <div class="links">
        <div class="mode">
            <div class="mode_set"></div>
        </div>
        <div class="sun_moon">
            <img src="./assets/icons/sun.png" alt="" class="weather">
        </div>
        <a href="/dashboard"><img src="./assets/icons/back.png" alt="">back</a>
    </div>
</nav>

<?php if ($dept == "laboratory"): ?>
    <h2 class="welcome">Each student is required to pay a mandatory sh200 for laboratory damages.</h2>
    <h2 class="welcome" style="width: 100%; text-align: center; font-size: 18px; color: red;">NOTE: If you damaged any laboratory equipment it's value will be inclusive in the value section.</h2>
<?php endif; ?>

<div class="details">
    <div class="profile"><img src="./assets/icons/dashboard.png" alt="">Student Dashboard - <?= $dept ?> department</div>
    <div><img src="./assets/icons/name.png" alt="">Name: <?= e($studentInfo['username']) ?></div>
    <div><img src="./assets/icons/admission.png" alt="">Admission: <?= e($studentInfo['admission number']) ?></div>
    <div><img src="./assets/icons/index.png" alt="">Index: <?= e($studentInfo['index number']) ?></div>
</div>

<div class="dept-details">

    <div class="lost">
        <h2><img src="./assets/icons/lost-items.png" alt=""><?= e($dept) ?> debt</h2>
        <ol>
            <li><?php echo $studentInfo[$dept . " " . "debt"] ?></li>
        </ol>
    </div>

    <div class="lost value">
        <h2><img src="./assets/icons/value.png" alt=""><?= e($dept) . "'s" ?> value</h2>
        <ol>
            <li>Ksh: <?= e($studentInfo[$dept . " " . "value"]) ?></li>
        </ol>
    </div>

    <?php if ($studentInfo[$dept . " status"] == "uncleared"): ?>

        <?php if ($studentInfo[$dept . " " . "value"] > 0 && $studentInfo[$dept . " " . "status"] == "uncleared" && $studentInfo[$dept . " " . "status"] != NULL && $studentInfo[$dept . " " . "debt"] != NULL): ?>

            <h2 style="color: red; font-size: 18px;">NOTE: Once done, this action can't be undone.</h2>
            <div class="payment">
                <a href="?action=pay_online&department=<?= e($_GET['department']) ?>"><img src="./assets/icons/online-payment.png" alt="">Pay online</a>
            </div>

            <h2 style="color: red; font-size: 18px;">NOTE: Once done, this action can't be undone.</h2>
            <div class="payment">
                <a href="?action=pay_physically&department=<?= e($dept) ?>"><img src="./assets/icons/pay_physically.png" alt="">Pay debt physically</a>
            </div>

        <?php else: ?>
            <h2 style="color: green; font-size: 18px;">Looks like you were a very responsible student 💯👍.</h2>
            <div class="payment">
                <a href="?action=no_debt&department=<?= e($dept) ?>"><img src="./assets/icons/debt-free.png" alt="">Looks like you have no outstanding debts click here to clear.</a>
            </div>
        <?php endif; ?>

    <?php endif; ?>

    <?php if ($studentInfo[$dept . " " . "status"] == "online"): ?>
        <div class="status dept_status">
            <h2><img src="./assets/icons/pending.png" alt="">Fully cleared, payment made via online phone number: </h2>
        </div>
    <?php endif; ?>

    <?php if ($studentInfo[$dept . " " . "status"] == "cleared"): ?>
        <div class="status dept_status">
            <h2><img src="./assets/icons/pending.png" alt="">Fully cleared, no debt cease to exists 💯.</h2>
        </div>
    <?php endif; ?>

    <?php if ($studentInfo[$dept . " " . "status"] == "pending_physical_payment"): ?>
        <div class="status dept_status">
            <h2><img src="./assets/icons/pending.png" alt="">Partially cleared, pending physical clearance.</h2>
        </div>
        <div class="status dept_status">
            <h2>*** You are partially cleared and required to bring
                <?php if ($studentInfo[$dept . " " . "debt"] != "none") {
                    echo $studentInfo[$dept . " " . "debt"] . ", Market value sh: " . $studentInfo[$dept . " " . "value"];
                } else {
                    echo "sh " . $studentInfo[$dept . " " . "value"];
                }
                ?> on your allocated pic up date. ***</h2>
        </div>
    <?php endif; ?>

    <?php if ($dept == "games" || $dept == "library" || $dept == "boarding" || $dept == "accessories"):  ?>
        <div class="status availability">
            <h2><img src="./assets/icons/availability.png" alt="">Availability: <?= e($studentInfo[$dept . " " . "availability"]) ?></h2>
        </div>
    <?php endif; ?>

    <div class="status status">
        <h2><img src="./assets/icons/cleared.png" alt=""><?= e($dept) ?> clearance status: <?= e($studentInfo[$dept . " " . "status"]) ?>
            <?php if ($studentInfo[$dept . " " . "status"] == "uncleared" || $studentInfo[$dept . " " . "status"] == "pending_physical_payment"): ?>
                ❎
            <?php else: ?>
                ✅
            <?php endif; ?>
        </h2>
    </div>

</div>

<?php loadFooter() ?>
