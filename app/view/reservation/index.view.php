<?php

layout('header.php');
?>

<?php
layout('nav.php');
?>
<div class="flex min-h-full flex-col justify-center px-6 py-5  lg:px-8">
    <form action="/user/reservation" method="POST">
        <div class="space-y-2">
            <label for="reservation-date">Select a date for reservation:</label>
            <input type="date" id="reservation-date" name="reservation_date" required>
            <p class="font-semibold">Choose an option:</p>
            <?php foreach ($time_slots as $slot): ?>
            <label class="flex items-center space-x-2">
                <input type="radio" name="time_slot" value="<?= $slot['id'] ?>" class="text-blue-600 focus:ring-blue-500"/>
                <span><?= $slot['start_time'] .'-'.$slot['end_time']  ?></span>
            </label>
            <?php endforeach; ?>
        </div>
        <button type="submit"
                class="m-4 flex justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 p-4">
           Book
        </button>
    </form>
</div>