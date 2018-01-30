<div class="section-panel">
    <form action="options.php" method="post">
        <?php
        settings_fields("map_general_options");
        do_settings_sections("map-tool");
        ?>
        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>">
        </p>
    </form>
</div>