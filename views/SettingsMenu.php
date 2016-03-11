<?php

namespace WooBoPolis\views;

/**
 * Description of SettingsMenu
 *
 * @author ctala
 */
class SettingsMenu {

    public static function generateSettings() {
        if (isset($_POST["actualizar"])) {
            $access_token = esc_attr($_POST["access_token"]);
            $resource_token = esc_attr($_POST["resource_token"]);

            update_option("cubopolis_access_token", $access_token);
            update_option("cubopolis_resource_token", $resource_token);
        }
        ?>
        <div class="wrap">

            <div class="wrap">
                <h2>CuboPolis Settings</h2>



                <form method="POST" action="">
                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row">
                                <label for="num_elements">
                                    ACCESS_TOKEN:
                                </label> 
                            </th>
                            <td>
                                <input type="text" name="access_token" size="100" value="<?php echo get_option("cubopolis_access_token") ?>" />
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="num_elements">
                                    RESOURCE_TOKEN:
                                </label> 
                            </th>
                            <td>
                                <input type="text" name="resource_token" size="100" value="<?php echo get_option("cubopolis_resource_token") ?>"/>
                            </td>
                        </tr>
                    </table>
                    <input type="submit" name="actualizar" value="Actualizar Datos">
                </form>
            </div>
            <?php
        }

    }
    