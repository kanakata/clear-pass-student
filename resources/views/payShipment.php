<?php loadHeader("request shipment") ?>

<nav>
    <?php if (isset($_GET['dept'])): ?>
        <h2><img src="./assets/icons/dashboard.png" alt="">pay <?= e($_GET['dept']) ?> online</h2>
    <?php else: ?>
        <h2><img src="./assets/icons/dashboard.png" alt="">Request shipment</h2>
    <?php endif; ?>
    <div class="links">
        <div class="mode">
            <div class="mode_set"></div>
        </div>
        <div class="sun_moon">
            <img src="./assets/sun.png" alt="" class="weather">
        </div>
    </div>
</nav>

<div class="actions">

    <?php if (!isset($_POST['destination'])): ?>

        <div class="forms">
            <form action="" method="post">
                <h2>Select your location.</h2>
                <label for="shipment_destination">
                    <img src="./assets/icons/fast-delivery.png" alt="">
                    <select name="location" id="" required>

                        <?php foreach ($destinations as $destination): ?>
                            <option value="<?= e($destination['location']) ?>"><?= e($destination['location']) ?></option>
                        <?php endforeach; ?>

                    </select>
                </label>
                <input type="submit" name="destination" value="submit">
            </form>
        </div>

    <?php else: ?>

        <div class="forms">
            <form action="" method="post">
                <h2>Shipment form</h2>
                <label for="username">
                    <img src="./assets/icons/name.png" alt="">
                    <input type="text" value="Username: <?= e($studentInfo['username']) ?>" name="username" readonly>
                </label>
                <label for="admission">
                    <img src="./assets/icons/admission.png" alt="">
                    <input type="text" name="admission" value="Admission: <?= e($studentInfo['admission number']) ?>" readonly>
                </label>
                <label for="phone">
                    <img src="./assets/icons/index.png" alt="">
                    <input type="text" name="phone" placeholder="phone(254700000000)" required>
                </label>
                <label for="location">
                    <img src="./assets/icons/fast-delivery.png" alt="">
                    <input type="text" name="location" value="<?= e("shipment location: " . $destinationInfo['location']) ?>" readonly>
                </label>
                <label for="location">
                    <img src="./assets/icons/fast-delivery.png" alt="">
                    <input type="text" name="courier" value="<?= e("courier: " . $destinationInfo['courrier']) ?>" readonly>
                </label>
                <label for="location">
                    <img src="./assets/icons/fast-delivery.png" alt="">
                    <input type="text" name="pic_up_point" value="<?= e("Collection point: " . $destinationInfo['pic up location']) ?>" readonly>
                </label>
                <label for="location">
                    <img src="./assets/icons/online_payment.png" alt="">
                    <input type="text" name="price" value="<?= e("shipment cost: sh" . $destinationInfo['price']) ?>" readonly>
                </label>
                <!-- <label for="password">
                    <img src="./assets/icons/password.png" alt="">
                    <input type="password" name="password" placeholder="password" required>
                </label> -->
                <input type="submit" value="Complete shipment request" name="payShipment">
            </form>
        </div>
    <?php endif; ?>
    
    <?php loadFooter() ?>
