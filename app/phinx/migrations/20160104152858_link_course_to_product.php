<?php

use Phinx\Migration\AbstractMigration;

class LinkCourseToProduct extends AbstractMigration
{
  /**
   * Change Method.
   *
   * Write your reversible migrations using this method.
   *
   * More information on writing migrations is available here:
   * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
   *
   * The following commands can be used in this method and Phinx will
   * automatically reverse them when rolling back:
   *
   *    createTable
   *    renameTable
   *    addColumn
   *    renameColumn
   *    addIndex
   *    addForeignKey
   *
   * Remember to call "create()" or "update()" and NOT "save()" when working
   * with the Table class.
   */
  public function change()
  {
    $this->execute("
      ALTER TABLE training_course
        ADD COLUMN billing_product_id INT (11) NOT NULL AFTER date_created;
    ");

    $this->execute("
      ALTER TABLE training_course
        ADD INDEX (billing_product_id);
    ");

    $this->execute("
      ALTER TABLE training_course
        ADD CONSTRAINT training_course_ibfk_1 FOREIGN KEY (billing_product_id) REFERENCES billing_product (billing_product_id);
    ");
  }
}
