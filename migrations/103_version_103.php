<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_images_table extends CI_Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE `tblimages` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `image_path` VARCHAR(255) NOT NULL,
                `category_id` INT(11) NOT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                FOREIGN KEY (`category_id`) REFERENCES `tblvideo_categories`(`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");
    }

    public function down()
    {
        $this->db->query("DROP TABLE `tblimages`");
    }
}
