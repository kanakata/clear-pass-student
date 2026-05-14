<?php if (!empty($_SESSION['popup_message'])): ?>
    <div class="alert" style="display: block;">
        <div class="alert_title">🔔🔔🔔 alert</div>
        <div class="close">close<img src="./assets/icons/x.svg" alt=""></div>
        <div class="alert_message"><?= e($_SESSION['popup_message']) ?></div>
    </div>
    <?php unset($_SESSION['popup_message']) ?>
<?php endif; ?>


<!-- department confirmation popup -->
<?php
$action = $_GET['action'] ?? null;
if (isset($action) && $action !== null):
    // 1. Resolve the department value safely
    $currentDept = e($_GET['department'] ?? $dept ?? '');

    // 2. Determine the proceed link
    $proceedLink = ($action === "pay_physically")
        ? "?proceed&department=$currentDept"
        : "/payDebt?&department=$currentDept";
?>

    <div class="alert" style="display: block;">
        <div class="alert_title">Confirm: <?= e(str_replace('_', ' ', $action)) ?></div>

        <div class="alert_message" style="display: flex; gap: 15px; justify-content: center; padding: 15px;">

            <a href="<?= $proceedLink ?>" style="text-decoration: none; background: green; height: 40px; width: 150px; display: flex; align-items: center; justify-content: center; font-size: 18px; border-radius: 5px; color: white;">Proceed</a>

            <a href="?&department=<?= $currentDept ?>" style="text-decoration: none; background: red; height: 40px; width: 150px; display: flex; align-items: center; justify-content: center; font-size: 18px; border-radius: 5px; color: white;">Cancel</a>

        </div>
    </div>

<?php endif; ?>
