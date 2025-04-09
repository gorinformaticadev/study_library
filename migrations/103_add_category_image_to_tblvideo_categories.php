<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_category_image_to_tblvideo_categories extends CI_Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE `tblvideo_categories` ADD `category_image` VARCHAR(255) NULL DEFAULT NULL AFTER `category`");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE `tblvideo_categories` DROP `category_image`");
    }
}
