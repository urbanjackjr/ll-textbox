<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       netkeeper.pl
 * @since      1.1.0
 *
 * @package    Ll_Textbox
 * @subpackage Ll_Textbox/public/partials
 */

global $wpdb;

$saved_words = $wpdb->get_results("SELECT * FROM wp_learn_language WHERE user_id=" . get_current_user_id());
$word_count = is_array($saved_words) ? count($saved_words) : 0;
?>

<h3><?php _e('My Saved Words', 'tutor'); ?></h3>
<?php
if ($word_count){
    ?>
    <table>
        <tr>
            <th><?php echo 'Saved word' ?></th>
            <th><?php echo 'Translation' ?></th>
        </tr>
        <?php
        foreach ( $saved_words as $word){
            $saved_word = $word->ll_value;
            $translation = $word->ll_translation;
            $is_learned = $word->is_learned;
            ?>
            <tr>
                <td>
                    <?php echo $saved_word ?>
                </td>
                <td>
                    <?php echo $translation ?>
                </td>
            </tr>
            <?php
        }
        ?>

    </table>

<?php } else {
    echo 'You have not saved any words yet';
} ?>