<?php
/**
 * Created by PhpStorm.
 * User: ah1
 * Date: 2019-06-28
 * Time: 16:02
 */

namespace AuthorBio\Classes;


class AccessControl
{
    public static function hasTopLevelMenuPermission()
    {
        $menuPermissions = array(
            'manage_options',
            'wpf_full_access',
            'wpf_can_view_menus'
        );
        foreach ($menuPermissions as $menuPermission) {
            if (current_user_can($menuPermission)) {
                return $menuPermission;
            }
        }
        return false;
    }
}
